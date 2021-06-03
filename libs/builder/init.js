$(document).ready(function(){

    $("#save-btn").click(function(e){
        e.preventDefault();
        setTimeout(function() {
            $('#iframe1').load(location.href);
        }, 5000);
    });
    function toSlug(text){
        text = "" + text;
        return text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
    }

    $.ajax({
        url: "/editor/update",
        type: "GET",
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            var item = data.item;
            var store = data.store;
            for (var i = 0; i < item.length; i = i + 1) {
                
                var listItemString = $("#listItem").html();
                var slug = toSlug(item[i].item_name);
                var link = '/store/i/'+ store["store_url_slug"] + '/' + item[i].id + '/' + slug;
                var url = "/uploads/store/items/" + item[i].item_featured_image;
                var listItem = $("<div class='col-lg-3 col-md-4 col-sm-12'>" + listItemString + "</div>");
                    var listItemTitle = $("#order-title", listItem);
                        listItemTitle.html(item[i].item_name);
                    var listItemImage = $("#order-img", listItem);
                        listItemImage.attr("src", url);
                    var listItemPrice = $("#order-price", listItem);
                        listItemPrice.html('₦' + item[i].item_amount);
                    var listItemLink = $("#order-link", listItem);
                        listItemLink.attr("href", link);
                        $("#dataOrder").append(listItem);
            }
        }
    });
});
