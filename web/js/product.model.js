function Product() {
    this.id = 0;
    this.title = '';
    this.alias = '';
    this.sort = 0;
    this.status = 10;
    this.price = 0;
    this.description_short = '';
    this.description = '';
    this.image = '';
    this.step = 1;
    this.count = 1;
}

Product.prototype.fillParams = function (params) {

    this.id = params['id'];
    this.title = params['title'];
    this.alias = params['alias'];
    this.sort = params['sort'];
    this.status = params['status'];
    this.price = params['price'];
    this.description_short = params['description_short'];
    this.description = params['description'];
    this.image = params['image'];
    this.step = params['step'];
    this.count = params['count'];

};
