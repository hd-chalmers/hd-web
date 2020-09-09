<template>
    <div>
        <v-row v-for="(row,key) in rows" :key="key" style="page-break-after: always" dense>
            <v-col cols="4" class="text-center" v-for="(user, key) in row" :key="user.id">
                <strong v-if="user.name !== ''" style="overflow: hidden">{{ user.name.substr(0, 20) }}</strong>
                <strong v-else><span style="color: transparent">Empty</span></strong>
                <VueBarcode :value="user.uid" height="30">
                    Test
                </VueBarcode>
            </v-col>
        </v-row>
        <v-row v-for="(row,key) in inactive_rows" :key="key" style="page-break-after: always" class="text-center" dense>
            <v-col cols="12">
                <h5>INACTIVE</h5>
            </v-col>
            <v-col cols="4" class="text-center" v-for="(user, key) in row" :key="user.id">
                <strong v-if="user.name !== ''" style="overflow: hidden">{{ user.name.substr(0, 20) }}</strong>
                <strong v-else><span style="color: transparent">Empty</span></strong>
                <VueBarcode :value="user.uid" height="25">
                    {{user.uid}}
                </VueBarcode>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import VueBarcode from 'vue-barcode';

export default {
    name: "PrintView",
    components: {
        VueBarcode,
    },
    data() {
        return {
            rows: [],
            inactive_rows: [],
        }
    },
    created() {
        if (!(this.users.length % 30)) {
            this.users.push({'uid': 'USL' + (this.last.length < 3 ? '0' : '') + this.last, 'name': ''})
        }
        while (this.users.length > 0) {
            const howMany = 30
            while (this.users.length < 30) {
                this.last++;
                this.users.push({'uid': 'USL' + (this.last.length < 3 ? '0' : '') + this.last, 'name': ''})
            }
            const row = this.users.splice(0, howMany)
            this.rows.push(row)
        }
        while (this.inactive.length > 0) {
            const howMany = 30
            const row     = this.inactive.splice(0, howMany)
            this.inactive_rows.push(row)
        }
    },
    props: {
        users: Array,
        last: Number,
        inactive: Array,
    }
}
</script>

<style scoped>
</style>
