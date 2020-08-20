<template>
    <v-container fluid>
        <v-card>
            <v-card-title>Räknare</v-card-title>
            <v-card-actions>
                <v-btn icon x-large @click="doCount('reset')">
                    <v-icon>mdi-refresh</v-icon>
                </v-btn>
            </v-card-actions>
            <v-card-text>
                <v-text-field type="number" v-model="count" readonly>
                    <template v-slot:prepend>
                        <v-btn icon x-large @click="doCount('decrease')">
                            <v-icon>mdi-minus</v-icon>
                        </v-btn>
                    </template>
                    <template v-slot:append-outer>
                        <v-btn icon x-large @click="doCount('increase')">
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </template>
                </v-text-field>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "counter",
    created() {
        setInterval(this.doCount, 1000, ['get'])
    },
    data() {
        return {
            count: this.counter,
        }
    },
    props: {
      counter: {
          type: Number,
          required: true
      }
    },
    methods: {
        doCount(direction) {
            this.loading = true;
            axios(
                "/counter/"+direction,
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.count = res.data.count;
            }).catch(() => {
            }).finally(() => {
                this.loading = false;
            })
        }
    }
}
</script>

<style scoped>

</style>
