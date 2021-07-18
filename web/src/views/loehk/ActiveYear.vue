<template>
    <v-card :loading="loading">
        <v-card-title>
            <v-row>
                <v-col cols="12" sm="4" md="3">
                    <v-select :loading="loading" :items="all_years" v-model="active_year" item-text="displayed_year" item-value="id" return-object></v-select>
                    <v-btn v-if="all_years[0] && all_years[0].year !== (new Date().getFullYear())"
                           @click="addNewYear()" :color="errors.addYear? 'red' : 'inherit'">
                        Nytt år
                      <span style="color: red; position: absolute; bottom: -30px; left: 0;" v-if="errors.addYear">{{errors.addYear}}</span>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text>
            <v-form>
                <v-row>
                    <v-col cols="6">
                        <v-file-input show-size label="Gruppbild" :success-messages="message.group_photo" :messages="active_year.group_photo" :loading="load.group_photo === true" :success="load.group_photo === 'success'"
                                      :error-messages="errors.group_photo" v-model="form.group_photo"></v-file-input>
                    </v-col>
                    <v-col cols="6">
                        <v-file-input show-size label="Bakgrundsbild" :success-messages="message.background_image" :messages="active_year.background_image" :loading="load.background_image === true"
                                      :success="load.background_image === 'success'" :error-messages="errors.background_image" v-model="form.background_image"></v-file-input>
                    </v-col>
                    <v-col cols="6">
                        <v-file-input show-size label="Förstasidan, Bild" :success-messages="message.front_image" :messages="active_year.front_image" :loading="load.front_image === true" :success="load.front_image === 'success'"
                                      :error-messages="errors.front_image" v-model="form.front_image"></v-file-input>
                    </v-col>
                    <v-col cols="6">
                        <v-file-input show-size label="Förstasidan, Julbild" :success-messages="message.christmas_image" :messages="active_year.christmas_image" :loading="load.christmas_image === true"
                                      :error-messages="errors.christmas_image" :success="load.christmas_image === 'success'" v-model="form.christmas_image"></v-file-input>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea @input="saveDescriptionDebounced" :success-messages="message.description" counter label="Beskrivande text" :loading="load.description === true"
                                    :success="load.description === 'success'" v-model="active_year.description" :error-messages="errors.description"></v-textarea>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-btn @click="active_year.committee_members.push(JSON.parse(JSON.stringify(committee_member)))">Lägg till en person</v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <v-card class="mb-1" v-for="(committee_member, index) in active_year.committee_members" :key="committee_member.id">
                        <v-card-actions>
                            <v-btn icon @click="deleteCommitteeMember(committee_member, index)" :loading="getLoad('committee_member',committee_member.id+'delete')"
                                    :color="getErrors('committee_member', committee_member.id + 'delete') ? 'red' : 'inherit'">
                                <v-icon>mdi-delete</v-icon>
                              <span style="color: red; position: absolute; bottom: -30px; left: 0;" v-if="getErrors('committee_member', committee_member.id + 'delete')">
                                {{getErrors('committee_member', committee_member.id + 'delete')}}
                              </span>
                            </v-btn>
                        </v-card-actions>
                        <v-card-text>
                            <v-row>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Namn" @input="updateCommitteeMemberDebounced(committee_member.id, 'name', committee_member.name, index)" v-model="committee_member.name"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'name')"
                                                  :error-messages="getErrors('committee_member', committee_member.id + 'name')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Post" @input="updateCommitteeMemberDebounced(committee_member.id, 'role', committee_member.role, index)" v-model="committee_member.role"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'role')"
                                                  :error-messages="getErrors('committee_member', committee_member.id + 'role')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Beskrivning" @input="updateCommitteeMemberDebounced(committee_member.id, 'description', committee_member.description, index)" v-model="committee_member.description"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'description')"
                                                  :error-messages="getErrors('committee_member', committee_member.id + 'description')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Citat" @input="updateCommitteeMemberDebounced(committee_member.id, 'quote', committee_member.quote, index)" v-model="committee_member.quote"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'quote')"
                                                  :error-messages="getErrors('committee_member', committee_member.id + 'quote')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Favoritspel" @input="updateCommitteeMemberDebounced(committee_member.id, 'favourite_game', committee_member.favourite_game, index)" v-model="committee_member.favourite_game"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'favourite_game')"
                                                  :error-messages="getErrors('committee_member', committee_member.id + 'favourite_game')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Favoritsocker" @input="updateCommitteeMemberDebounced(committee_member.id, 'favourite_sugar', committee_member.favourite_sugar, index)" v-model="committee_member.favourite_sugar"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'favourite_sugar')"
                                                  :error-messages="getErrors('committee_member', committee_member.id + 'favourite_sugar')"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-file-input label="Profilbild" @change="updateCommitteeMemberDebounced(committee_member.id, 'image', committee_member.image_upload, index)" :messages="committee_member.image"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'image')" v-model="committee_member.image_upload"
                                                  :error-messages="getErrors('committee_member', committee_member.id + 'image')"></v-file-input>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-row>
            </v-form>
          <v-skeleton-loader v-if="loading" type="card@2" style="margin: 5px;"></v-skeleton-loader>
        </v-card-text>
    </v-card>
</template>

<script>

export default {
    name: "ActiveYear",
    created() {
        this.getActiveYear()
    },
    watch: {
        'form.front_image': function ($value, $old_value) {
            if (this.loading) {
                return;
            }
            this.load.front_image = true;
            this.errors.front_image = ''
            let data              = new FormData();
            data.append('front_image', $value, 'front_image');
            this.state.then(obj => {
              fetch(process.env.VUE_APP_API_URL + `/loehk/active_year?yearId=${this.active_year.id}`, {

                // Adding method type
                method: "PATCH",
                headers:{
                  sessionId: obj.SessionStore.getSessionId()
                },

                // Adding body or contents to send
                body: data
              })
                // Convey success
                .then(res => {
                  if (res.ok) {
                    this.load.front_image = 'success'
                    this.message.front_image = 'Sparat!'
                    return null
                  } else {
                    this.load.front_image = 'fail'
                    if(res.status === 415){
                      this.errors.front_image = 'denna filtyp är inte accepterat'
                    }
                    else if(res.status === 422){
                      this.errors.front_image = 'filen är för stor (>10MB)'
                    }
                    else if(res.status === 403) {
                      this.errors.front_image = 'utloggad, refresh?'
                    }
                    else {
                      this.errors.front_image = 'servern stötte på ett problem när den hanterade datan'
                    }
                  }
                }).catch((err) => {
                this.load.front_image = 'fail'
                this.errors.front_image = 'kunde inte nå servern'
                console.error(err)
              })
                .finally(() => {
                  this.loading = false;
                })
            })
        },
        'form.background_image': function ($value, $old_value) {
            if (this.loading) {
                return
            }
            this.load.background_image = true
            this.errors.background_image = ''
            let data                   = new FormData()
            data.append('background_image', $value, 'background_image')
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/active_year?yearId=${this.active_year.id}`, {

              // Adding method type
              method: "PATCH",

              headers: {
                sessionId: obj.SessionStore.getSessionId()
              },

              // Adding body or contents to send
              body: data
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.load.background_image = 'success'
                  this.message.background_image = 'Sparat!'
                  return null
                } else {
                  this.load.background_image = 'fail'
                  if(res.status === 415){
                    this.errors.background_image = 'denna filtyp är inte accepterat'
                  }
                  else if(res.status === 422){
                    this.errors.background_image = 'filen är för stor (>10MB)'
                  }
                  else if(res.status === 403) {
                    this.errors.background_image = 'utloggad, refresh?'
                  }
                  else {
                    this.errors.background_image = 'servern stötte på ett problem när den hanterade datan'
                  }
                }
              }).catch((err) => {
              this.load.background_image = 'fail'
              this.errors.background_image = 'kunde inte nå servern'
              console.error(err)
            }).finally(() => {
              this.loading = false
            })
          })
        },
        'form.group_photo': function ($value, $old_value) {
            if (this.loading) {
                return
            }
            this.load.group_photo = true
            this.errors.group_photo = ''
            let data              = new FormData()
            data.append('group_photo', $value, 'group_photo')
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/active_year?yearId=${this.active_year.id}`, {

              // Adding method type
              method: "PATCH",

              headers: {
                sessionId: obj.SessionStore.getSessionId()
              },

              // Adding body or contents to send
              body: data
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.load.group_photo = 'success'
                  this.message.group_photo = 'Sparat!'
                  return null
                } else {
                  this.load.group_photo = 'fail'
                  if(res.status === 415){
                    this.errors.group_photo = 'denna filtyp är inte accepterat'
                  }
                  else if(res.status === 422){
                    this.errors.group_photo = 'filen är för stor (>10MB)'
                  }
                  else if(res.status === 403) {
                    this.errors.group_photo = 'utloggad, refresh?'
                  }
                  else {
                    this.errors.group_photo = 'servern stötte på ett problem när den hanterade datan'
                  }
                }
              }).catch((err) => {
              this.load.group_photo = 'fail'
              this.errors.group_photo = 'kunde inte nå servern'
              console.error(err)
            })
              .finally(() => {
                this.loading = false;
              })
          })
        },
        'form.christmas_image': function ($value, $old_value) {
            if (this.loading) {
                return
            }
            this.load.christmas_image = true
            this.errors.christmas_image = ''
            let data                  = new FormData()
            data.append('christmas_image', $value, 'christmas_image');
            this.state.then(obj => {
              fetch(process.env.VUE_APP_API_URL + `/loehk/active_year?yearId=${this.active_year.id}`, {

                // Adding method type
                method: "PATCH",

                headers: {
                  sessionId: obj.SessionStore.getSessionId()
                },

                // Adding body or contents to send
                body: data
              })
                // Convey success
                .then(res => {
                  if (res.ok) {
                    this.load.christmas_image = 'success'
                    this.message.christmas_image = 'Sparat!'
                    return null
                  } else {
                    this.load.christmas_image = 'fail'
                    if(res.status === 415){
                      this.errors.christmas_image = 'denna filtyp är inte accepterat'
                    }
                    else if(res.status === 422){
                      this.errors.christmas_image = 'filen är för stor (>10MB)'
                    }
                    else if(res.status === 403) {
                      this.errors.christmas_image = 'utloggad, refresh?'
                    }
                    else {
                      this.errors.christmas_image = 'servern stötte på ett problem när den hanterade datan'
                    }
                  }
                }).catch((err) => {
                this.load.christmas_image = 'fail'
                this.errors.christmas_image = 'kunde inte nå servern'
                console.error(err)
              }).finally(() => {
                this.loading = false
              })
            })
        },
    },
    data() {
        return {
            loading: true,
            state: import('@/assets/ts/sessionStore'),
            active_year: {
                year: '',
                description: '',
                group_photo: '',
                front_image: '',
                christmas_image: '',
                background_image: '',
                committee_members: [],
                created_at: '',
                updated_at: '',
            },
            message: {
                description: '',
                group_photo: '',
                front_image: '',
                christmas_image: '',
                background_image: '',
                committee_member: {},
            },
            errors: {description: '',
              group_photo: '',
              front_image: '',
              christmas_image: '',
              background_image: '',
              addYear: '',
              addMember: '',
              committee_member: {}
            },
            form: {
                group_photo: null,
                front_image: null,
                christmas_image: null,
                background_image: null,
            },
            load: {
                group_photo: false,
                front_image: false,
                christmas_image: false,
                background_image: false,
                description: false,
                addYear: false,
                addMember: false,
                committee_member: {},
            },
            all_years: [],
            committee_member: {
                name: '',
                role: '',
                image: '',
                description: '',
                favourite_game: '',
                favourite_sugar: '',
                quote: '',
                image_upload: null,
                created_at: null,
                updated_at: null,
            }
        }
    },
    methods: {
        getMessage(type, id) {
            if (this.message[type][id]) {
                return this.message[type][id]
            }
            return '';
        },
      getErrors(type, id) {
        if (this.errors[type][id]) {
          return this.errors[type][id]
        }
        return '';
      },
        getLoad(type, id) {
            if (this.message[type][id]) {
                return this.message[type][id]
            }
            return false;
        },
        addNewYear() {
          this.load.addYear = true
          this.errors.addYear = ''
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/active_year`, {

              // Adding method type
              method: "POST",
              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  return res.json()
                } else {
                  if(res.status === 403) {
                    this.errors.addYear = 'utloggad, refresh?'
                  }
                  else {
                    this.errors.addYear = 'servern stötte på ett problem när den försökte skapa ett nytt år'
                  }
                  return null
                }
              })
              .then(res => {
                if(res) {
                  this.$set(this.all_years, this.all_years.length, res)
                  this.active_year = res
                }
              }).catch((err) => {
              this.errors.addYear = 'kunde inte nå servern'
              console.error(err)
            }).finally(() => {
              console.log('finally')
              this.load.addYear = false
            })
          })
        },
        updateCommitteeMemberDebounced(id, fieldname, value, index) {
            clearTimeout(this._updateCommitteeDebounce);
            this.$set(this.message.committee_member, id + fieldname, '')
            this._updateCommitteeDebounce = setTimeout(() => {
                this.updateCommitteeMember(id, fieldname, value, index)
            }, 500);
        },
        updateCommitteeMember(id, fieldname, value, index) {
            if (value === undefined || value === null || value === 'null') {
                return;
            }
            let data = new FormData();
            if (fieldname === 'image') {
                data.append(fieldname, value, fieldname);
            } else {
                data.append(fieldname, value);
            }
            data.append('active_year_id', this.active_year.id);

            this.$set(this.load.committee_member, id + fieldname, true)
            this.$set(this.message.committee_member, id + fieldname, '')
            this.$set(this.errors.committee_member, id + fieldname, '')

            this.state.then(obj => {
              fetch(process.env.VUE_APP_API_URL + `/loehk/active_year/committee_members${id ? '?memberId=' + id : ''}`, {

                // Adding method type
                method: "PATCH",

                headers: {
                  sessionId: obj.SessionStore.getSessionId()
                },

                // Adding body or contents to send
                body: data
              })
                // Convert to JSON and convey success
                .then(res => {
                  if (res.ok) {
                    if (!id) {
                      this.$set(this.message.committee_member, res?.id + fieldname, 'Success!')
                    } else {
                      this.$set(this.message.committee_member, id + fieldname, 'Success!')
                    }
                    return res.json()
                  } else {
                    if(res.status === 415){
                      this.$set(this.errors, id + fieldname, 'denna filtyp är inte accepterat')
                    }
                    else if(res.status === 422){
                      this.$set(this.errors, id + fieldname,'filen är för stor (>10MB)')
                    }
                    else if(res.status === 403) {
                      this.$set(this.errors.committee_member, id + fieldname, 'utloggad, refresh?')
                    }
                    else {
                      this.$set(this.errors.committee_member, id + fieldname, 'servern stötte på ett problem när den hanterade datan')
                    }
                    return null
                  }
                }).then(res => {
                if (res) {
                  this.$set(this.active_year.committee_members, index, res)
                }
              }).catch((err) => {
                this.$set(this.errors.committee_member, id + fieldname, 'kunde inte nå servern')
                console.error(err)
              }).finally(() => {
                this.$set(this.load.committee_member, id + fieldname, false)
              })
            })
        },
        deleteCommitteeMember(member, index) {
            this.$set(this.load.committee_member, member.id + 'delete', true)
            this.$set(this.message.committee_member, member.id + 'delete', '')
            this.$set(this.errors.committee_member, member.id + 'delete', '')

            // if member is a dummy then delete it from client since they're not in database
            if(!member.id){
              this.active_year.committee_members.splice(index, 1)
              return
            }

            this.state.then(obj => {
              fetch(process.env.VUE_APP_API_URL + `/loehk/active_year/committee_members`, {

                // Adding method type
                method: "DELETE",

                // Adding headers to request
                headers: {
                  "content-type": "application/json",
                  sessionId: obj.SessionStore.getSessionId()
                },

                // Adding body or contents to send
                body: JSON.stringify({ id: member.id })
              })
                // Convey success
                .then(res => {
                  if (res.ok) {
                    this.$set(this.message.committee_member, member.id + 'delete', false)
                    this.active_year.committee_members.splice(index, 1);
                  } else {
                    if(res.status === 403) {
                      this.$set(this.errors.committee_member, member.id + 'delete', 'utloggad, refresh?')
                    }
                    else {
                      this.$set(this.errors.committee_member, member.id + 'delete', 'servern stötte på ett problem när den skulle hantera datan')
                    }
                  }
                }).catch((err) => {
                this.$set(this.errors.committee_member, member.id + 'delete', 'kunde inte nå servern')
                console.error(err)
              }).finally(() => {
                this.$set(this.load.committee_member, member.id + 'delete', false)
              })
            })
        },
        getActiveYear() {
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + '/loehk/active_year', {
              headers: {
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              .then(res => res.json()).then((res) => {
              this.active_year = res.current;
              this.all_years = res.all_years;
            }).catch((err) => {
              console.error(err)
              this.$router.push('/login')
            }).finally(() => {
              this.loading = false;
            })
          })
        },
        saveDescriptionDebounced() {
            clearTimeout(this._SaveDescriptionDebounce);
            this.message.description = '';
            this._SaveDescriptionDebounce = setTimeout(() => {
                this.saveDescription()
            }, 500);
        },
        saveDescription() {
          if (this.loading) {
            return;
          }
          this.load.description = true;
          this.message.description = ''
          this.errors.description = ''
          this.state.then(obj => {
            fetch(process.env.VUE_APP_API_URL + `/loehk/active_year?yearId=${this.active_year.id}`, {

              // Adding method type
              method: "PATCH",

              // Adding body or contents to send
              body: JSON.stringify({ description: this.active_year.description }),

              // Adding headers to the request
              headers: {
                "Content-type": "application/json; charset=UTF-8",
                sessionId: obj.SessionStore.getSessionId()
              }
            })
              // Convey success
              .then(res => {
                if (res.ok) {
                  this.load.description = 'success'
                  this.message.description = 'Sparat!'
                } else {
                  if(res.status === 403){
                    this.errors.description = 'utloggad, refresh?'
                    this.errors.description = 'utloggad, refresh?'
                  }
                  else {
                    this.errors.description = 'servern stötte på något fel när den hanterade datan'
                  }
                  this.load.description = 'fail'
                }
              }).catch(() => {
              this.errors.description = 'kan inte nå servern'
              this.load.description = 'fail'
            }).finally(() => {
              this.loading = false;
            })
          })
        }
    }
}
</script>

<style scoped>

</style>
