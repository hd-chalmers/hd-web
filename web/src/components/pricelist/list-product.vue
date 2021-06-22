<template>
    <td v-if="!deleted">
        <a :href="base_url+'/'+product_id+'/edit'" style="color: black"> <i class="fas fa-edit"></i></a>
        <i class="fas fa-trash" style="cursor:pointer;" @click="doDelete"></i>
    </td>
    <td v-else>
        <strong>DELETED</strong>
    </td>
</template>

<script>
    export default {
        name: "list-product",

        data() {
            return {
                deleted: false
            }
        },

        props  : {
            product_id: {
                required: true,
                type    : String
            },
            product_name: {
                required: true,
                type    : String
            },
            base_url  : {
                required: true,
                type    : String
            }
        },
        methods: {
            doDelete: function () {
                if (confirm('Ta bort produkt '+this.product_name+'?')) {
                    this.$snotify.async(
                        '',
                        'Tar Bort',
                        () => {
                            return new Promise((success, fail) => {
                                axios(
                                    "/products/" + this.product_id,
                                    {
                                        method         : 'DELETE',
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
                                    this.deleted = true;
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
                                        body  : '',
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
                    )
                }
            }
        }
    }
</script>

<style scoped>

</style>
