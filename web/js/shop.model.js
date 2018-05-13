function Shop() {
    this.products = {};
    this.basketProducts = {};
    this.productElementClass = 'shop-product';
    this.payButtonClass = 'pay-button';

}

Shop.prototype.clickPayButton = function (buttonClass = '') {

    this.payButtonClass = buttonClass.length > 0 ? buttonClass : this.payButtonClass;
    let productList = this.products;

    let self = this;
    let buttonClick = document.getElementsByClassName(this.payButtonClass);

    [].slice.call(buttonClick).forEach(function (item) {
        item.addEventListener('click', function () {
            self.pay(productList[item.dataset.productId]);
        });
    });
};

/** Заполняем объект products продуктами, которые есть на странице */
Shop.prototype.fillProducts = function (productElementClass = '') {

    this.productElementClass = productElementClass.length > 0 ? productElementClass : this.productElementClass;

    let productElements = document.getElementsByClassName(this.productElementClass);

    for (let i = 0; i < productElements.length; i++) {
        let product = new Product();

        product.fillParams(productElements[i].dataset);

        this.addProduct(product);
    }

    console.log('products');
    console.log(this.products);
};

/** Возвращает продукт из объекта products - товары на странице */
Shop.prototype.getProduct = function (productID) {
    if (this.products[productID].length > 0) {
        return this.products[productID];
    } else {
        console.log('Error getProduct: not found product: ' + productID);
    }
};

/** Возвращает продукт из объекта basketProducts - товары в корзине */
Shop.prototype.getBasketProduct = function (productID) {
    if (this.basketProducts[productID].length > 0) {
        return this.basketProducts[productID];
    } else {
        console.log('Error getBasketProduct: not found product: ' + productID);
    }
};

/** Положить товар в корзину */
Shop.prototype.pay = function (product) {

    console.log('this.basketProducts');
    console.log(this.basketProducts);

    if (product instanceof Product) {

        let csrf = document.querySelector("meta[name='csrf-token']").getAttribute("content");

        let self = this;
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                self.addBasketProduct(product);

                console.log('pay responseText: ');
                console.log(this.responseText);
            }
        };

        xhttp.open("POST", "/basket/product/pay", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("productID=" + product.id + "&count=" + product.count + '&_csrf=' + csrf);
    }
};

/** Удалить товар из корзины */
Shop.prototype.excludePay = function (productID) {
    if (this.products[productID].length > 0) {
        console.log('productID: ');
        console.log(productID);

        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                console.log('excludePay responseText: ');
                console.log(this.responseText);
            }
        };

        xhttp.open("POST", "/shop/products/exclude-pay", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("productID=" + productID);

        this.removeBasketProduct(productID);
    } else {
        console.log('Error dontPay: not found product: ' + productID);
    }
};

/** Добавить продукт в объект products - товары на странице */
Shop.prototype.addProduct = function (product) {
    if (product instanceof Product) {
        this.products[product.id] = product;
    }
};

/** Добавить продукт в объект basketProducts - добавленные в корзину */
Shop.prototype.addBasketProduct = function (product) {
    if (product instanceof Product) {
        this.basketProducts[product.id] = product;
    }
};

/** Удалить продукт из объекта products - товары на странице */
Shop.prototype.removeProduct = function (productID) {
    if (this.products[productID].length > 0) {
        delete this.products[productID];
    } else {
        console.log('Error removeProduct: not found product: ' + productID);
    }
};

/** Удалить продукт из объекта products - товары на странице */
Shop.prototype.removeBasketProduct = function (productID) {
    if (this.basketProducts[productID].length > 0) {
        delete this.basketProducts[productID];
    } else {
        console.log('Error removeBasketProduct: not found product: ' + productID);
    }
};
