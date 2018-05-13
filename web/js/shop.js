let catalogProductClass = '';

let shop = new Shop();
let basket = new Basket();


$(document).ready(function () {

    shop.fillProducts();
    shop.clickPayButton();
    // basket.fillProducts('basket-product');
    //
    // $('.pay-button')

});
