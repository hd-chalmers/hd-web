<template>
    <div>
        <v-btn fab bottom right fixed :color="color" :large="$vuetify.breakpoint.mobile" :loading="loading" @click="showDate">
            <v-icon>{{ icon }}</v-icon>
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

<script lang="ts">
import axios from 'axios'

export default {
  name: 'ChassitOpenIcon',
  created ():void {
    this.getStatus()
    setInterval(this.getStatus, 3000)
  },
  methods: {
    showDate ():void {
      if (this.state !== -1) {
        this.snackbar = true
      }
    },
    getStatus ():void {
      axios(
        '/door',
        {
          method:
                        'get',
          withCredentials:
                        true,
          responseType:
                        'json',
          timeout: 3000,
          headers:
                        {
                          'Content-Type':
                                'application/json',
                          Accept:
                                'application/json'
                        }
        }).then(res => {
        this.state = res.data.status
        this.date = res.data.updated
        this.duration = res.data.duration_str
        if (res.data.status) {
          this.icon = 'mdi-lock-open-variant'
          this.color = 'green'
        } else {
          this.icon = 'mdi-lock'
          this.color = 'red'
        }
      }).catch(() => {
        this.state = -1
        this.icon = 'mdi-alert-circle'
        this.color = 'yellow'
      }).finally(() => {
        this.loading = false
      })
    }
  },
  // eslint-disable-next-line @typescript-eslint/ban-types
  data (): object {
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
