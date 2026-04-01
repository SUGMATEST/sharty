$(function () {
    if (localStorage.nsfw_filter !== 'false') {
        let nsfwThreshold = 0.20;
        if (localStorage.nsfw_threshold) {
            nsfwThreshold = localStorage.nsfw_threshold;
        }

        let mode = 'hide-image';
        if (localStorage.nsfw_filter_mode) {
            mode = localStorage.nsfw_filter_mode;
        }

        function checkNsfw() {
            const nsfwProb = $(this).html();

            if (nsfwProb >= nsfwThreshold) {
                let $img = null;
                if (active_page == "catalog") {
                    $img = $(this).parents('.thread').find('.thread-image');
                }
                else {
                    $img = $(this).parents('.file').find('.post-image');
                }

                switch (mode) {
                    case 'blur-image':
                        $img.css('filter', 'blur(20px)');
                        break;
                    case 'hide-image':
                    default:
                        $img.attr('src', '/static/nsfw-warning.png')
                        .css('height', '128px')
                        .css('width', '128px');
                        break;
                }
            }
        }

        $(document).on('new_post', function (e, post) {
            $(post).find('.nsfw-prob').each(checkNsfw);
        });

        $('.nsfw-prob').each(checkNsfw);
    }

    if (window.Options) {
        Options.add_tab("nsfw-filter", "none", _("NSFW Filter"));
        Options.extend_tab('nsfw-filter', '<label id="hide-nsfw"><input type="checkbox">Enable NSFW filtering</label>');
        Options.extend_tab('nsfw-filter', '<i>By disabling this setting, you agree that you are 18+</i><br>');
        Options.extend_tab('nsfw-filter', 'Filter mode: <select id="nsfw-filter-mode"><option id="hide-nsfw" value="hide-image">Hide images</option><option id="blur-nsfw" value="blur-image">Blur images</option></select>');
        Options.extend_tab('nsfw-filter', 'Auto detection sensitivity: <select id="nsfw-threshold"><option id="auto-off" value=1>Off, manually tagged only</option><option id="auto-low" value=0.8>Low</option><option id="auto-medium" value=0.5>Medium</option><option id="auto-high" value=0.2>High</option></select>');


        $('#hide-nsfw>input').on('change', function () {
            if (localStorage.nsfw_filter !== 'false') {
                localStorage.nsfw_filter = 'false';
            } else {
                localStorage.nsfw_filter = 'true';
            }
        });

        $('#nsfw-threshold').on('change', function (e) {
            localStorage.nsfw_threshold = e.target.value;
        });

        $('#nsfw-filter-mode').on('change', function (e) {
            localStorage.nsfw_filter_mode = e.target.value;
        });

        if (localStorage.nsfw_filter !== 'false') {
            $('#hide-nsfw>input').attr('checked', 'checked');
        }

        switch (localStorage.nsfw_threshold) {
            case $('#auto-off').attr('value'):
                $('#auto-off').attr('selected', 'selected');
                break;
            case $('#auto-medium').attr('value'):
                $('#auto-medium').attr('selected', 'selected');
                break;
            case $('#auto-high').attr('value'):
                $('#auto-high').attr('selected', 'selected');
                break;
            default:
                $('#auto-low').attr('selected', 'selected');
                localStorage.nsfw_threshold = $('#auto-low').attr('value');
        }

        switch (localStorage.nsfw_filter_mode) {
            case $('#blur-nsfw').attr('value'):
                $('#blur-nsfw').attr('selected', 'selected');
                break;
            default:
                $('#hide-nsfw').attr('selected', 'selected');
                localStorage.nsfw_filter_mode = 'hide-image';
        }
    }
});
