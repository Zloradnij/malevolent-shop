

function Basket() {
    Shop.call(this);
}

Basket.prototype = Object.create(Shop.prototype);
Basket.prototype.constructor = Basket;

Basket.productElementClass = 'basket-product';


Basket.prototype.pay = function (product) {
    if (product instanceof Product) {
        console.log('product: ');
        console.log(product);

        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                this.addProduct(product);

                console.log('responseText: ');
                console.log(this.responseText);
            }
        };

        xhttp.open("POST", "/basket/product/add", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("productID=" + product.id + "&count=" + product.count);
    }
};

Basket.prototype.dontPay = function (productID) {
    if (this.products[productID].length > 0) {
        console.log('productID: ');
        console.log(productID);

        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log('responseText: ');
                console.log(this.responseText);
            }
        };

        xhttp.open("POST", "/shop/products/remove", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("productID=" + productID);

        this.removeProduct(productID);
    } else {
        console.log('Error: not found product: ' + productID);
    }
};

Basket.prototype.getPrice = function () {
    let sum = 0;

    for (let product in this.products) {
        sum += product.price;
    }

    return sum;
};

Basket.prototype.getCount = function () {
    return this.products.length;
};


