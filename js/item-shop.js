+function () {

    var itemshop_handler, itemshop_background, itemshop_div
        , itemshop_close;

    var ItemShop = {};
    window.ItemShop = ItemShop;

    ItemShop.selectedItem = null;
    ItemShop.selectedPost = null;

    ItemShop.show = function (postNo) {
        ItemShop.selectedPost = postNo;
        ItemShop.fetchItems();
        ItemShop.fetchBalance();
        itemshop_handler.fadeIn();
    };
    ItemShop.hide = function () {
        itemshop_handler.fadeOut();
        $('.itemshop-item').removeClass('selected');
        ItemShop.selectedItem = null;
        ItemShop.selectedPost = null;
    };

    ItemShop.fetchItems = function () {
        $.ajax({
            url: '/shop.php?board=' + board_name,
            dataType: 'json',
            success: function (data) {
                const itemlist = $('#itemshop_itemlist');
                itemlist.empty();

                if (data['error']) {
                    itemlist.html(data['error']);
                    return;
                }

                for (const [i, item] of data.entries()) {
                    let itemElement = $('<div class="itemshop-item"></div>').attr('data-itemid', i);
                    itemElement.append($('<img class="itemshop-item-icon">').attr('src', item['icon']));
                    itemElement.append($('<div></div>').html(item['name']));
                    itemElement.append($('<div></div>').html('Price: ' + item['price']));
                    itemElement.append($('<div></div>').html(item['description']));

                    itemElement.on('click', function(e) {
                        $('.itemshop-item').removeClass('selected');
                        e.currentTarget.setAttribute('class', e.currentTarget.className + ' selected');
                    });

                    itemlist.append(itemElement);
                }
            }
        });
    };

    ItemShop.fetchBalance = function () {
        $.ajax({
            url: '/shop.php',
            data: { 'balance': true, 'password': localStorage.password },
            dataType: 'json',
            method: 'POST',
            success: function (data) {
                $('#itemshop_balance').html('Balance: ' + data['balance']);
            }
        });
    };

    itemshop_handler = $("<div id='itemshop_handler'></div>").css("display", "none");
    itemshop_background = $("<div id='itemshop_background'></div>").on("click", ItemShop.hide).appendTo(itemshop_handler);
    itemshop_div = $("<div id='itemshop_div'></div>").appendTo(itemshop_handler);
    $('<h2>Give an Award</h2>').appendTo(itemshop_div);
    itemshop_itemlist = $("<div id='itemshop_itemlist'></div>").appendTo(itemshop_div);
    itemshop_balance = $("<div id='itemshop_balance'></div>").appendTo(itemshop_div);
    itemshop_buybutton = $("<input id='itemshop_balance' type='button' value='Buy'></div>").appendTo(itemshop_div);
    itemshop_close = $("<a id='itemshop_close' href='javascript:void(0)'><i class='fa fa-times'></i></div>")
        .on("click", ItemShop.hide).appendTo(itemshop_div);


    $(function () {
        itemshop_buybutton.on('click', function() {
            ItemShop.selectedItem = $('.itemshop-item.selected').attr('data-itemid');
            if (!ItemShop.selectedItem) {
                alert('No item selected.');
                return;
            }

            $.ajax({
                url: '/shop.php',
                data: {
                    'purchase': true,
                    'board': board_name,
                    'post-id': ItemShop.selectedPost,
                    'item-id': ItemShop.selectedItem,
                    'password': localStorage.password,
                },
                dataType: 'json',
                method: 'POST',
                success: function(data) {
                    if (data['error']) {
                        alert(data['error']);
                        return;
                    }

                    if (data['success']) {
                        alert("Award given!");
                        ItemShop.fetchBalance();
                    }
                },
            });
        });

        itemshop_handler.appendTo($(document.body));
    });

}();