setupsse = function() {
	console.log("setting up sse");
	if (!('thread_id' in window) || !('board_name' in window)) {
		console.log("not in a thread");
		return; //live index one day
	}
    let eventSource;
    let retryInterval = 1000; 
    const maxRetryInterval = 5000;

    function connectSSE() {
        eventSource = new EventSource(`/sse?thread=${thread_id}&board=${board_name}`);

        eventSource.onmessage = function(event) {
            console.log('Received SSE message:', event.data);
            
            const updateThreadButton = document.getElementById('update_thread');
            if (updateThreadButton) {
                updateThreadButton.click();
            } else {
                console.error('#update_thread element not found. JS up?');
            }

            retryInterval = 1000;
        };

        eventSource.onopen = function(event) {
            console.log('SSE connection opened');
            retryInterval = 1000;
            //<input type="checkbox" id="auto_update_status">
            var checkbox = document.getElementById("auto_update_status");
            if (checkbox) {
                checkbox.checked = true;
                checkbox.click();
            }
        };

        eventSource.onerror = function(event) {
            console.error('SSE connection error:', event);
            eventSource.close();
            setTimeout(() => {
                retryInterval = Math.min(retryInterval * 2, maxRetryInterval);
                connectSSE();
            }, retryInterval);
            var checkbox = document.getElementById("auto_update_status");
            if (checkbox) {
                checkbox.checked = false;
                checkbox.click();
            }
        };
    }

    connectSSE();
};
const delayedSetupSSE = function() {
    setTimeout(setupsse, 100);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', delayedSetupSSE);
} else {
    delayedSetupSSE();
}
