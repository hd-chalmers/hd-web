<template>
    <div class="container bg-light py-1">
        <form @submit.prevent.stop="submit(false)">
            <div class="row">
                <div class="col-12">
                    <h3>Ny Produkt</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="product_name">Kategori <span style="color: red">*</span></label>
                    <select class="custom-select" required v-model="product.category_id">
                        <option selected disabled>Välj Kategori</option>
                        <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                    </select>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="product_name">Namn <span style="color: red">*</span></label>
                        <input type="text" class="form-control" id="product_name" placeholder="Produkt"
                               v-model="product.name" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <input type="number" step="0.01" class="form-control" id="purchase_price"
                                   placeholder="Inköpspris" v-model.number="product.purchase_price" required>
                        </div>
                        <input type="number" step="0.01" class="form-control" id="deduction"
                               placeholder="Kampanjavdrag" v-model.number="product.discount">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                Sälj för: {{sale_price}}:-
                            </div>
                        </div>
                        <span style="color: red">*</span>
                        <i class="fas fa-info-circle"
                           title="Axfood kvittot visar rabatt som total för hela antalet som köptes in"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-row form-inline">
                        <div class="col-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1"
                                       v-model="product.pant">
                                <label class="custom-control-label" for="customCheck1">Pant</label>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="form-group">
                                <label for="product_name">Antal per förpackning</label>
                                <input type="number" class="form-control" id="package" min="1" required
                                       placeholder="Antal per Förpackning" v-model.number="product.package"> <span style="color: red">*</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <table class="table table-sm table-hover">
                        <thead>
                        <tr>
                            <th>
                                Streckkod <span style="color: red">*</span>
                            </th>
                            <th>
                                Alternativt Namn (Krävs ej)
                            </th>
                            <th>
                                <i class="fas fa-plus-square" style="cursor: pointer"
                                   @click="product.barcodes.push({variant_name: '', barcode: ''})"></i>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(barcode, index) in product.barcodes">
                            <td>
                                <input type="text" class="form-control" id="barcode"
                                       placeholder="XXXXXXXXX" v-model="barcode.barcode" :required="index === 0">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="alt_name"
                                       placeholder="Chips (OLW Sourcream)" v-model="barcode.variant_name">
                            </td>
                            <td v-if="product.barcodes.length > 1">
                                <em style="cursor: pointer" class="fas fa-trash"
                                    @click="product.barcodes.splice(index, 1)"></em>
                            </td>
                            <td v-else></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary">
                    Spara
                </button>
                <button class="btn btn-success" type="button">
                    Spara och skapa ny
                </button>
            </div>
        </form>

    </div>
</template>

<script>
    export default {
        name    : "new-product",
        props   : {
            categories: {
                required: true,
                type    : Array
            },
        },
        computed: {
            sale_price() {
                return Math.ceil((this.product.purchase_price - this.product.discount) / this.product.package * 1.12 + (this.product.pant ? 1 : 0));
            }
        },
        methods : {
            submit: function (restart) {
                this.$snotify.async(
                    '',
                    'Lägger till',
                    () => {
                        return new Promise((success, fail) => {
                            axios(
                                "/products",
                                {
                                    data           : JSON.stringify(this.product),
                                    method         : 'post',
                                    withCredentials: true,
                                    responseType   : 'json',
                                    headers        :
                                        {
                                            'Content-Type':
                                                'application/json',
                                            'Accept'      :
                                                'application/json',
                                        },
                                }).then(res => {
                                success({
                                    title : '',
                                    body  : 'Klar!',
                                    config: {
                                        closeOnClick   : true,
                                        showProgressBar: true
                                    }
                                });
                            }).catch((res) => {
                                fail({
                                    title : 'Ett fel inträffade',
                                    body  : res.data.message,
                                    config:
                                        {
                                            titleMaxLength: 30,
                                            closeOnClick  : true,
                                        }
                                });
                            }).finally(() => {

                            })
                        });
                    }
                );
            }
        },
        data() {
            return {
                category: {
                    name: '',
                    id  : 0,
                },
                product : {
                    name          : '',
                    category_id   : null,
                    purchase_price: null,
                    discount      : null,
                    price         : null,
                    active        : true,
                    pant          : false,
                    package       : 1,
                    barcodes      : [
                        {variant_name: '', barcode: ''}
                    ],
                },
                barcode : {
                    variant_name: '',
                    barcode     : '',
                }
            }
        },
    }
</script>

<style scoped>

</style>
