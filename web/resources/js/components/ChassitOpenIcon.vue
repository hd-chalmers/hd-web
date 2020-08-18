<template>
    <v-btn fab bottom right fixed :color="color" :loading="loading" @click="showDate">
        <v-icon>{{icon}}</v-icon>
    </v-btn>
</template>

<script>
export default {
    name: "ChassitOpenIcon",
    created() {
        this.getStatus();
        setInterval(this.getStatus, 3000)
    },
    methods: {
        showDate() {
          if (this.state !== -1) {

          }
        },
        getStatus() {
            axios(
                "/door",
                {
                    method:
                        'get',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.state = res.data.status;
                this.date = res.data.updated;
                if (res.data.status) {
                    this.icon = 'mdi-lock-open-variant';
                    this.color = 'green';
                } else {
                    this.icon = 'mdi-lock'
                    this.color = 'red';
                }
            }).catch(() => {
                this.state = -1;
                this.icon = 'mdi-alert-circle';
                this.color = "yellow";
            }).finally(() => {
                this.loading = false;
            })
        }
    },
    data() {
        return {
            loading: true,
            state: true,
            date: '0000-00-00 00:00:00',
            icon: 'mdi-alert-circle',
            color: 'white',
        }
    }
}
</script>

<style scoped>

</style>
