<template>
    <div>
        <v-btn fab bottom right fixed :color="color" :large="$vuetify.breakpoint.mobile" :loading="loading" @click="showDate" style="bottom: 28px;">
            <lock-icon v-if="icon === 'lock'"/>
            <unlock-icon v-if="icon === 'unlock'"/>
            <alert-circle-icon v-if="icon === 'alert'"/>
        </v-btn>

        <v-snackbar
            v-model="snackbar"
            :timeout="2000"
            shaped
            top
        >
            <center>
                {{ date }}
                <br/>
                {{ duration }}
            </center>
        </v-snackbar>
    </div>
</template>

<script lang="js">
import {LockIcon, UnlockIcon, AlertCircleIcon} from 'vue-feather-icons'

export default {
  name: 'ChassitOpenIcon',
  created () {
    this.getStatus()
    setInterval(this.getStatus, 10000)
  },
  components: {
    LockIcon,
    UnlockIcon,
    AlertCircleIcon
  },
  methods: {
    showDate () {
      this.getStatus()
      if (this.state !== -1) {
        this.snackbar = true
      }
    },
    getStatus () {
      fetch(process.env.VUE_APP_API_URL + '/door')
        .then(res => {
          if(res.ok) {
            return res.json()
          }
          else {
            this.state = -1
            this.icon = 'alert'
            this.color = 'warning'
            return null
          }
        }).then(res => {
          if(res) {
            this.state = res.status
            this.date = res.updated
            this.duration = res.duration_str
            if (res.status) {
              this.icon = 'unlock'
              this.color = 'success'
            } else if (res.status === null) {
              this.state = -1
              this.icon = 'alert'
              this.color = 'warning'
            } else {
              this.icon = 'lock'
              this.color = 'error'
            }
          }
      }).catch(() => {
        this.state = -1
        this.icon = 'alert'
        this.color = 'warning'
      }).finally(() => {
        this.loading = false
      })
    }
  },
  data () {
    return {
      snackbar: false,
      loading: true,
      state: true,
      duration: '',
      date: '0000-00-00 00:00:00',
      icon: 'mdi-alert-circle',
      color: 'white'
    }
  }
}
</script>

<style scoped>

</style>
