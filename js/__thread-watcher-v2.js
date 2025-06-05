function ensureToastContainer() {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.position = 'fixed';
        container.style.bottom = '0';
        container.style.left = '0';
        container.style.right = '0';
        document.body.appendChild(container);
    }
    return container;
}
var toastContainer = null;
function createSubscribeButton() {
    if (typeof thread_id == "undefined") {
        return;
    }
    
    var str = "op_" + thread_id;
    const threadElement = document.getElementById(str);
    if (!threadElement) return;

    const firstP = threadElement.querySelector('p');
    if (!firstP) return;

    const quoteLink = firstP.querySelector('a.post_quote');
    if (!quoteLink) return;

    const subscribeSpan = document.createElement('span');
    subscribeSpan.id = 'thread-subscribe';

    const button = document.createElement('a');
    button.id = 'subscribe-button';
    button.href = 'javascript:void(0);';
    button.onclick = () => toggleSubscription(thread_id, board_name);
    

    subscribeSpan.appendChild(button);

    quoteLink.insertAdjacentElement('afterend', subscribeSpan);
    quoteLink.insertAdjacentText('afterend', ' ');

    updateSubscribeButtonText();
}

function toggleSubscription(threadId, boardName) {
    let subscriptions = JSON.parse(localStorage.getItem('threadSubscriptions') || '{}');
    let key = `${boardName}:${threadId}`;
    
    if (subscriptions[key]) {
        delete subscriptions[key];
        Toastify({
            text: "Unsubscribed from thread",
            duration: 3000,
            close: true,
            gravity: "bottom",
            position: "right",
			selector: toastContainer,
            backgroundColor: "#4CAF50",
        }).showToast();
    } else {
        subscriptions[key] = true;
        Toastify({
            text: "Subscribed to thread",
            duration: 3000,
            close: true,
            gravity: "bottom",
            position: "right",
			selector: toastContainer,
            backgroundColor: "#2196F3",
        }).showToast();
    }
    
    localStorage.setItem('threadSubscriptions', JSON.stringify(subscriptions));
    updateSubscribeButtonText();
}

function updateSubscribeButtonText() {
    const button = document.getElementById('subscribe-button');
    if (!button) return;

    let subscriptions = JSON.parse(localStorage.getItem('threadSubscriptions') || '{}');
    let key = `${board_name}:${thread_id}`;
    
    button.textContent = subscriptions[key] ? '[Unsubscribe]' : '[Subscribe]';
}

function setupThreadWatcherSSE() {
    console.log("setting up thread watcher sse");
    
    let eventSource;
    let retryInterval = 1000; 
    const maxRetryInterval = 30000;
	var threadID = "0";
	if (typeof thread_id != "undefined") {
		threadID = thread_id;
	}

    function connectSSE() {
        eventSource = new EventSource(`/sse`);

        eventSource.onmessage = function(event) {
            console.log('Received thread watcher SSE message:', event.data);
            
            if (event.data.startsWith('json,')) {
                const jsonData = JSON.parse(event.data.slice(5));
				if (threadID != jsonData.thread.toString()){
					let subscriptions = JSON.parse(localStorage.getItem('threadSubscriptions') || '{}');
                
					if (subscriptions[`${jsonData.board}:${jsonData.thread}`]) {
						var url = configRoot;
						if (inMod) {
							url += "mod.php?/"
						}
						url += `${jsonData.board}`;
						url += `/thread/`;
						url += `${jsonData.thread}.html`;
						url += `#q${jsonData.id}`
						Toastify({
							text: `New post in ${jsonData.board}/${jsonData.thread}.`,
							destination: url,
							duration: 5000,
							close: true,
							gravity: "bottom",
							position: "right",
							selector: toastContainer,
							backgroundColor: "#2196F3",
						}).showToast();
					}
				}
			}

            retryInterval = 1000;
        };

        eventSource.onopen = function(event) {
            console.log('thread watcher SSE connection opened');
            retryInterval = 1000;
        };

        eventSource.onerror = function(event) {
            console.error('thread watcher SSE connection error:', event);
            eventSource.close();
            setTimeout(() => {
                retryInterval = Math.min(retryInterval * 2, maxRetryInterval);
                connectSSE();
            }, retryInterval);
        };
    }

    connectSSE();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
		toastContainer = ensureToastContainer();
        createSubscribeButton();
        setupThreadWatcherSSE();
    });
} else {
	toastContainer = ensureToastContainer();
    createSubscribeButton();
    setupThreadWatcherSSE();
}
