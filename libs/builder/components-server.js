Vvveb.ServersGroup['Server Components'] = ["servers/orderform"];

Vvveb.Servers.add("servers/orderform", {
    name: "Product",
    dragHtml: '<img src="' + Vvveb.baseUrl + 'icons/order.svg" height="150px" width="100px">',
    image: "icons/order.svg",
    html: '<div class="row" id="dataOrder"></div>\
            <div class="col-lg-12 col-md-12 col-sm-12" id="listItem">\
                <div class="card-body col-lg-12 col-md-12 col-sm-12" id="card-order-body">\
                    <img class="card-img-top img-responsive" id="order-img" src="../libs/builder/icons/image.svg" alt="order-img" height="300px">\
                    <h4 class="card-title" id="order-title">Sample Product</h4>\
                    <p id="order-price">₦ 0.00</p>\
                    <a href="#" id="order-link" class="btn btn-danger">Order Now</a>\
                </div>\
            </div>',
    dragStart: function (node)
    {
        body = Vvveb.Builder.frameBody;
        if ($("#product-script", body).length == 0)
        {
        $(body).append(
            '<script id="product-script" src="../../libs/builder/init.js"></script>'
        );
    }
        return node;
    },
    // init: function (node)
    // {
    //     this.node = node;

    //     return node;
    // },


    // beforeInit: function (node)
    // {

    //     return node;
    // },
});
