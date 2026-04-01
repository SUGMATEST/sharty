if (active_page === 'thread' || active_page === 'index' || active_page === 'ukko') {
	$(document).on('menu_ready', function () {
        let domain = location.hostname;
        if (domain.includes('.onion')) {
            domain = 'soyjak.st';
        }

        const Menu = window.Menu;
        const submenu = Menu.add_submenu('archive-menu', _('Archive post'));

        //submenu.add_item('archive-cellar', 'View post on The Cellar');
        //submenu.add_item('archive-archivetoday', 'Archive on archive.today');
        submenu.add_item('archive-ghostarchive', 'Archive on Ghostarchive');
        submenu.add_item('archive-megalodon', 'Archive on megalodon.jp');
        //submenu.add_item('archive-wayback', 'Archive on the Wayback Machine');

        Menu.onclick(function (e, $buffer) {
            const $post = $(e.target.parentElement.parentElement);

            const threadId = $post.parent().attr('id').replace('thread_', '');
            const postId = $post.find('.post_no').not('[id]').text();

            let threadUrl = 'https://' + domain + '/' + board_name + '/thread/' + threadId + '.html';
            if (postId != threadId) {
                threadUrl += '#' + postId;
            }

            $buffer.find('#archive-cellar').on('click', function() {
                window.open(threadUrl.replace(domain, 'archive.soyjak.st').replace('.html', '').replace('#', '#p'), '_blank');
            });

            $buffer.find('#archive-archivetoday').on('click', function() {
                window.open('https://archive.ph/?url=' + threadUrl, '_blank');
            });

            $buffer.find('#archive-ghostarchive').on('click', function() {
                window.open('https://ghostarchive.org/search?term=' + threadUrl, '_blank');
            });

            $buffer.find('#archive-wayback').on('click', function() {
                window.open('https://web.archive.org/save/' + threadUrl, '_blank');
            });

            $buffer.find('#archive-megalodon').on('click', function() {
                window.open('https://gyo.tc/' + threadUrl, '_blank');
            });
        });
    });
}
