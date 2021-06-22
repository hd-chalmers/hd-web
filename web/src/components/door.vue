<template>
    <div class="col-lg-2 col-xl-3 text-center text-lg-right text-right">
        <a href="/door" style="color: black; text-decoration: none">
        <span v-if="status" :title="'Chassit öppnades ' + updated">
            Chassit är öppet
        </span>
            <span v-else :title="'Chassit stängdes '   +   updated">
            Chassit är stängt
        </span>
        </a>
    </div>
</template>

<script>
    export default {
        name   : "door",
        data() {
            return {
                timer  : null,
                status : 0,
                updated: "0000-00-00 00:00"
            }
        },
        props  : {
            door: {
                type    : Object,
                required: false
            }
        },
        created() {
            this.timer   = setInterval(this.update, 5000);
            this.status  = this.door.status;
            this.updated = this.door.updated;
        },
        methods: {
            update() {
                axios("/door",
                    {
                        method         : 'get',
                        withCredentials: true,
                        responseType   : 'json',
                        headers        :
                            {
                                'Content-Type':
                                    'application/json',
                                'Accept'      :
                                    'application/json',
                            },
                    }
                ).then(res => {
                    this.status  = res.data.status;
                    this.updated = res.data.updated;
                })
            },
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>

<style scoped>

</style>
