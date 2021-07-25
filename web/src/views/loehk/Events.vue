<template>
    <v-card :loading="loading">
        <v-card-title>
            <v-row>
                <v-col cols="12" md="8" lg="8">
                    <v-select label="Event" :loading="this.isLoading('newEvent')" :items="allEvents" v-model="event" item-text="title" item-value="id" return-object @input="reset">
                        <template v-slot:item="
                          // eslint-disable-next-line vue/no-unused-vars
                          {parent, item, on, attrs}">
                            {{ item.date }} {{item.time}} - {{ item.title }}
                        </template>
                        <template v-slot:selection="
                          /* eslint-disable-next-line vue/no-unused-vars */
                          {parent, item, index, select, selected, disabled}">
                            {{ item.date }} {{item.time}} - {{ item.title }}
                        </template>
                        <template v-slot:append-outer>
                            <v-switch v-if="event && event.id !== -1" label="Visa på sidan" v-model="event.show_on_frontpage" :loading="isLoading('show_on_frontpage')" :success-messages="hasSuccessMessage('show_on_frontpage')"
                                      :error-messages="hasError('show_on_frontpage')" @change="updateField('show_on_frontpage')" class="my-auto mr-1"></v-switch>

                            <v-btn v-if="event && event.id !== -1" :color="hasError('deleteEvent')? 'error' : 'inherit'" icon @click="deleteEvent" class="mr-2" :loading="isLoading('deleteEvent')">
                              <v-icon>mdi-delete</v-icon>
                              <span :style="`color: ${$vuetify.theme.currentTheme.error}; position: absolute; bottom: -30px;`" v-if="hasError('deleteEvent')">{{hasError('deleteEvent')}}</span>
                            </v-btn>
                            <v-btn @click="addNewEvent()" :loading="isLoading('newEvent')" :color="hasError('newEvent')? 'error' : 'inherit'">
                                Nytt Event
                              <span :style="`color: ${$vuetify.theme.currentTheme.error}; position: absolute; bottom: -30px;`" v-if="hasError('newEvent')">{{hasError('newEvent')}}</span>
                            </v-btn>
                        </template>
                    </v-select>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text v-if="event && event.id !== -1">
            <v-row>
                <v-col cols="12" md="4" lg="3">
                    <v-text-field v-model="event.title" prepend-icon="mdi-format-title" label="Titel" :loading="isLoading('title')"
                                  :success-messages="hasSuccessMessage('title')" @input="updateField('title')" :error-messages="hasError('title')"></v-text-field>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <v-menu
                        ref="dateMenu"
                        v-model="dateMenu"
                        :close-on-content-click="false"
                        :return-value.sync="event.date"
                        transition="scale-transition"
                        offset-y
                        @update:return-value="saveDate"
                        max-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                :loading="isLoading('date')"
                                :success-messages="hasSuccessMessage('date')"
                                :error-messages="hasError('date')"
                                v-model="event.date"
                                label="Datum"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="event.date"
                            type="date"
                            no-title
                            scrollable
                        >
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="dateMenu = false">Cancel</v-btn>
                            <v-btn text color="primary" @click="$refs.dateMenu.save(event.date)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <v-menu
                        ref="timeMenu"
                        v-model="timeMenu"
                        :close-on-content-click="false"
                        :return-value.sync="event.time"
                        transition="scale-transition"
                        offset-y
                        @update:return-value="saveTime"
                        max-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                :loading="isLoading('time')"
                                :success-messages="hasSuccessMessage('time')"
                                :error-messages="hasError('time')"
                                v-model="event.time"
                                label="Tid"
                                prepend-icon="mdi-clock"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-time-picker
                            v-model="event.time"
                            format="24hr"
                            no-title
                            scrollable
                        >
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="timeMenu = false">Cancel</v-btn>
                            <v-btn text color="primary" @click="$refs.timeMenu.save(event.time)">OK</v-btn>
                        </v-time-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <v-text-field v-model="event.description" prepend-icon="mdi-calendar-text" label="Beskrivning" :loading="isLoading('description')"
                                  :success-messages="hasSuccessMessage('description')" :error-messages="hasError('description')" @input="updateField('description')"></v-text-field>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <v-text-field v-model="event.location" prepend-icon="mdi-google-maps" label="Plats" :loading="isLoading('location')" :success-messages="hasSuccessMessage('location')"
                                  :error-messages="hasError('location')" @input="updateField('location')"></v-text-field>
                </v-col>
                <v-col cols="12" md="4" lg="3">
                    <v-text-field v-model="event.facebook_event_link" prepend-icon="mdi-facebook" label="Facebook Länk" :loading="isLoading('facebook_event_link')" :success-messages="hasSuccessMessage('facebook_event_link')"
                                  :error-messages="hasError('facebook_event_link')" @input="updateField('facebook_event_link')"></v-text-field>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from 'axios'

export default {
    name: "Events",
    created() {
        this.getEvents();
    },
    data() {
        return {
            loading: false,
            state: import('@/assets/ts/sessionStore'),
            defaultEvent: {
                title: 'Nytt Event',
                description: '',
                location: '',
                poster: '',
                show_on_frontpage: false,
                google_event_id: '',
                facebook_event_link: '',
                date: new Date().toISOString().substr(0, 10),
                time: '17:00',
            },
            event: {
                id: -1,
                title: 'Nytt Event',
                description: '',
                location: '',
                poster: null,
                show_on_frontpage: false,
                google_event_id: '',
                facebook_event_link: '',
                date: new Date(),
            },
            load: {},
            message: {},
            errors: {},
            allEvents: [
            ],
            dateMenu: null,
            timeMenu: null,
        }
    },
    watch: {

    },
    methods: {
        saveTime: function() {
            this.$set(this.load, 'time', true);
            this.$set(this.errors, 'time', '')
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/events?eventId=${this.event.id}`, {

              // Adding method type
              method: "PATCH",

              // Adding body or contents to send
              body: JSON.stringify({
                time: this.event.time
              }),

              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.$set(this.message, 'time', 'Success!');
                } else {
                  if(res.status === 403){
                    this.$set(this.errors, 'time', 'utloggad, refresh?')
                  }
                  else {
                    this.$set(this.errors, 'time', 'servern stötte på ett problem när den försökte hantera datan')
                  }
                }
              }).catch(() => {
              this.$set(this.errors, 'time', 'kunde inte nå servern')
            }).finally(() => {
              this.$set(this.load, 'time', false);
            })
          })
        },
        saveDate: function() {
            this.$set(this.load, 'date', true);
            this.$set(this.errors, 'date', '')
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/events?eventId=${this.event.id}`, {

              // Adding method type
              method: "PATCH",

              // Adding body or contents to send
              body: JSON.stringify({
                date: this.event.date
              }),

              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.$set(this.message, 'date', 'Success!');
                } else {
                  if(res.status === 403){
                    this.$set(this.errors, 'date', 'utloggad, refresh?')
                  }
                  else {
                    this.$set(this.errors, 'date', 'servern stötte på ett problem när den försökte hantera datan')
                  }
                }
              }).catch((err) => {
              this.$set(this.errors, 'date', 'kunde inte nå servern')
              console.error(err)
            }).finally(() => {
              this.$set(this.load, 'date', false);
            })
          })
        },
        isLoading(id) {
            if (this.load[id]) {
                return this.load[id]
            }
            return false;
        },
        hasSuccessMessage(id) {
            if (this.message[id]) {
                return this.message[id]
            }
            return '';
        },
        hasError(id){
          if(this.errors[id]){
            return this.errors[id]
          }
          return ''
        },
        updateField(fieldname) {
            this.$set(this.message, fieldname, '')
            this.$set(this.errors, fieldname, '')
            this.$set(this.load, fieldname, true);
          clearTimeout(this._updateField);
            this._updateField = setTimeout(() => {this.doUpdateField(fieldname)}, 500)
        },
        doUpdateField(fieldname) {
            this.$set(this.load, fieldname, true);
            this.$set(this.message, fieldname, '')
            this.$set(this.errors, fieldname, '')
            let value = this.event[fieldname];
            if (value === undefined || value === null || value === 'null') {
                return;
            }

            // Prepare for conversion to json
            let dataObj = {};
            dataObj[fieldname] = this.event[fieldname]
          /*
            if (fieldname === 'image') {
                data.append(fieldname, this.event[fieldname], fieldname);
            } else {
                data.append(fieldname, this.event[fieldname]);
            }*/
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/events?eventId=${this.event.id}`, {

              // Adding method type
              method: "PATCH",

              // Convert to JSON and send
              body: JSON.stringify(dataObj),

              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.$set(this.message, fieldname, 'Success!')
                } else {
                  if(res.status === 403){
                    this.$set(this.errors, fieldname, 'utloggad, refresh?')
                  }
                  else {
                    this.$set(this.errors, fieldname, 'servern stötte på ett problem när den försökte hantera datan')
                  }
                }
              }).catch((err) => {
              this.$set(this.errors, fieldname, 'kunde inte nå servern')
              console.error(err)
            }).finally(() => {
              this.$set(this.load, fieldname, false);
            })
          })
        },
        getEvents() {
            this.$set(this, "loading", true);
            this.state.then((obj) => {
              fetch(process.env.VUE_APP_API_URL + '/loehk/events', {
                headers:{
                  sessionId: obj.SessionStore.getSessionId()
                }
              })
                .then(res => res.json()).then((res) => {
                this.$set(this, "allEvents", res);
                this.event = this.allEvents[this.allEvents.length - 1];
              }).catch(() => {
                console.log('login failed')
                this.$router.push('/login')
              }).finally(() => {
                this.$set(this, "loading", false);
              })
            })
        },
        deleteEvent() {
            this.$set(this.load, "deleteEvent", true);
            this.$set(this.message, "deleteEvent", '');
            this.$set(this.errors, 'deleteEvent', '')
          this.state.then(obj => {
            fetch (process.env.VUE_APP_API_URL + `/loehk/events`, {

            // Adding method type
            method: "DELETE",

            // Convert to JSON and send
            body: JSON.stringify({ id: this.event.id }),

            // Adding headers to the request
            headers: {
              "Content-type": "application/json; charset=UTF-8",
              sessionId: obj.SessionStore.getSessionId()
            }
          })
            // Convey success
            .then(res => {
              if (res.ok) {
                this.$set(this.message, "deleteEvent", 'Success!');
                this.getEvents();
              } else {
                if(res.status === 403){
                  this.$set(this.errors, 'deleteEvent', 'utloggad, refresh?')
                }
                else {
                  this.$set(this.errors, 'deleteEvent', 'servern stötte på ett problem när den försökte hantera datan')
                }
              }
            }).catch(() => {
            this.$set(this.errors, 'deleteEvent', 'kunde inte nå servern')
          }).finally(() => {
            this.$set(this.load, "deleteEvent", false);
          })
        })
        },
        addNewEvent() {
          this.$set(this.errors, 'newEvent', '')

          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/events`, {

              // Adding method type
              method: "POST",

              // Convert to JSON and send
              body: JSON.stringify(this.defaultEvent),

              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convert to JSON and convey success
              .then(res => {
                if (res.ok) {
                  this.$set(this.message, "newEvent", 'Success!');
                  return res.json()
                } else {
                  if(res.status === 403){
                    this.$set(this.errors, 'newEvent', 'utloggad, refresh?')
                  }
                  else {
                    this.$set(this.errors, 'newEvent', 'servern stötte på ett problem när den försökte hantera datan')
                  }
                  return null
                }
              })
              .then(res => {
                if(res) {
                  let i = this.allEvents.push(res);
                  this.event = this.allEvents[i - 1];
                }
              })
              .catch((err) => {
                this.$set(this.errors, 'newEvent', 'servern kunde inte nås')
                console.error(err)
              })
              .finally(() => {
                this.$set(this.load, "newEvent", false);
              })
          })
        },
        reset(event) {
            this.load = null;
            this.load = {};
            this.message = null;
            this.message = {};
        }
    }
}
</script>

<style scoped>

</style>
