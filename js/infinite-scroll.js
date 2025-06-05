/*
 * infinite-scroll.js
 * https://github.com/vichan-devel/vichan/blob/master/js/infinite-scroll.js
 *
 * Released under the MIT license
 * Copyright (c) 2013-2014 Marcin Łabanowski <marcin@6irc.net>
 *
 * Usage:
 *   $config['additional_javascript'][] = 'js/jquery.min.js';
 *   $config['additional_javascript'][] = 'js/infinite-scroll.js';
 *
 */

$(function() {
    if (window.Options && Options.get_tab('general') && window.jQuery) {
		Options.extend_tab('general', '<label id="infinite-scroll"><input type="checkbox">' + _('Infinite scroll') + '</label>');

		$('#infinite-scroll>input').on('change', function() {
			if (localStorage.infinite_scroll !== 'false') {
				localStorage.infinite_scroll = 'false';
				$(window).off('scroll');
			} else {
				localStorage.infinite_scroll = 'true';
				activate();
			}
		});

		if (localStorage.infinite_scroll !== 'false') {
			$('#infinite-scroll>input').attr('checked','checked');
		}
	}

    if (active_page == 'index') {
    
    
    var loading = false;
    
    var activate = function() {
      if (localStorage.infinite_scroll == 'false') return false;
    
      $(window).on("scroll", function() {
        scrolltest();
      });
      scrolltest();
    
      return true;
    };
    
    var scrolltest = function() {
      if ($(window).scrollTop() + $(window).height() + 1000 > $(document).height() && !loading) {
        load_next_page();
      }
    };
    
    var load_next_page = function() {
        if (loading) return;
        loading = true;
        
        var this_page = $(".pages a.selected:last");
        var next_page = this_page.next();
        
        var href = next_page.prop("href");
        if (!href) return;
        
        var boardheader = $('<h2>'+_('Page')+' '+next_page.html()+'</h2>');
        var loading_ind = $('<h2>'+_('Loading...')+'</h2>').insertBefore('#post-moderation-fields');
        
        $.get(href, function(data) {
            var doc = $(data);
            
            loading_ind.remove();
            boardheader.insertBefore('#post-moderation-fields');
            
            var i = 0;
            
            doc.find('div[id*="thread_"]').each(function() {
                var checkout = $(this).attr('id').replace('thread_', '');
                var $this = this;
                
                if ($('div#thread_' + checkout).length == 0) {
                    // Delay DOM insertion to lessen the lag.
                    setTimeout(function() {
                        $($this).insertBefore('#post-moderation-fields');
                        $(document).trigger('new_post', $this);
                        $($this).hide().slideDown();
                    }, 500*i);
                    
                    i++;
                }
            });
            
            setTimeout(function() {
                loading = false;
                scrolltest();
            }, 500*(i+1));
            
            next_page.addClass('selected');
        });
    };
    
    $(window).on("hashchange", function() {
      return !activate();
    });
    activate();
    
    
    }
    });
    
