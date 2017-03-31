$( window ).load(function() {
    
    discount = $("#initProductDiscount").val();
    console.log(discount);
    
    function getTotal (){
        var discountOverQty = 3; //can be changed to work dynamically as well
        var price = ($("#price").val());
        var qty = $("#qty").val();
        $.ajax({
            url: "http://aivonix.name/management/calcDiscount/"+discountOverQty+"/"+qty+"/"+price+"/"+(discount/100)+"/true",
        })
        .done(function( data ) {
            var regex = /\d+(\.\d+)?/g;
            $( "#total" ).val(data.match(regex).map(function(v) { return parseFloat(v).toFixed(2); }));
        });
    };
    
    $( "#product" ).change(function() {
        var productID = ($("#product").find(":selected").attr("value"));
        $.ajax({
            url: "http://aivonix.name/management/getProductPrice/"+productID+"/true",
        })
        .done(function( data ) {
            var regex = /\d+(\.\d+)?/g;
            var product = (JSON.parse(data));
            $("#price").val( product.price.match(regex).map(function(v) { return parseFloat(v).toFixed(2); }) );
            getTotal();
            discount = product.discount;
        });
    });
    
    $( "#qty" ).change(function() {
        var discountOverQty = 3; //can be changed to work dynamically as well
        var price = ($("#price").val());
        var qty = $(this).val();
        $.ajax({
            url: "http://aivonix.name/management/calcDiscount/"+discountOverQty+"/"+qty+"/"+price+"/"+(discount/100)+"/true",
        })
        .done(function( data ) {
            var regex = /\d+(\.\d+)?/g;
            $( "#total" ).val(data.match(regex).map(function(v) { return parseFloat(v).toFixed(2); }));
        });
    });
    
});

