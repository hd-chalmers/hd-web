<template>
    <v-card :loading="loading">
        <v-card-title>
            <v-row>
                <v-col cols="12" sm="4" md="3">
                    <v-select :loading="loading" :items="all_years" v-model="active_year" item-text="displayed_year" item-value="year"></v-select>
                    <v-btn v-if="all_years[0] && all_years[0].year !== (new Date().getFullYear())"
                           @click="addNewYear()">
                        Nytt år
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text>
            <v-form>
                <v-row>
                    <v-col cols="6">
                        <v-file-input show-size label="Gruppbild" :success-messages="message.group_photo" :messages="active_year.group_photo" :loading="load.group_photo === true" :success="load.group_photo === 'success'"
                                      v-model="form.group_photo"></v-file-input>
                    </v-col>
                    <v-col cols="6">
                        <v-file-input show-size label="Bakgrundsbild" :success-messages="message.background_image" :messages="active_year.background_image" :loading="load.background_image === true"
                                      :success="load.background_image === 'success'" v-model="form.background_image"></v-file-input>
                    </v-col>
                    <v-col cols="6">
                        <v-file-input show-size label="Förstasidan, Bild" :success-messages="message.front_image" :messages="active_year.front_image" :loading="load.front_image === true" :success="load.front_image === 'success'"
                                      v-model="form.front_image"></v-file-input>
                    </v-col>
                    <v-col cols="6">
                        <v-file-input show-size label="Förstasidan, Julbild" :success-messages="message.christmas_image" :messages="active_year.christmas_image" :loading="load.christmas_image === true"
                                      :success="load.christmas_image === 'success'" v-model="form.christmas_image"></v-file-input>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea @input="message.description = ''; load.description = false" @focusout="saveDescription" :success-messages="message.description" counter label="Beskrivande text" :loading="load.description === true"
                                    :success="load.description === 'success'" v-model="active_year.description"></v-textarea>
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
                            <v-btn icon @click="deleteCommitteeMember(committee_member, index)" :loading="getLoad('committee_member',committee_member.id+'delete')">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-card-text>
                            <v-row>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Namn" @focusout="updateCommitteeMember(committee_member.id, 'name', committee_member.name, index)" v-model="committee_member.name"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'name')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Post" @focusout="updateCommitteeMember(committee_member.id, 'role', committee_member.role, index)" v-model="committee_member.role"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'role')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Beskrivning" @focusout="updateCommitteeMember(committee_member.id, 'description', committee_member.description, index)" v-model="committee_member.description"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'description')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Citat" @focusout="updateCommitteeMember(committee_member.id, 'quote', committee_member.quote, index)" v-model="committee_member.quote"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'quote')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Favoritspel" @focusout="updateCommitteeMember(committee_member.id, 'favourite_game', committee_member.favourite_game, index)" v-model="committee_member.favourite_game"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'favourite_game')"></v-text-field>
                                </v-col>
                                <v-col cols="6" lg="4">
                                    <v-text-field label="Favoritsocker" @focusout="updateCommitteeMember(committee_member.id, 'favourite_sugar', committee_member.favourite_sugar, index)" v-model="committee_member.favourite_sugar"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'favourite_sugar')"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-file-input label="Profilbild" @change="updateCommitteeMember(committee_member.id, 'image', committee_member.image_upload, index)" :messages="committee_member.image"
                                                  :success-messages="getMessage('committee_member', committee_member.id+'image')" v-model="committee_member.image_upload"></v-file-input>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-row>
            </v-form>
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
            let data              = new FormData();
            data.append('front_image', $value, 'front_image');
            axios(
                "/loehk/active_year/" + this.active_year.id + "/update",
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    data: data,
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'multipart/form-data',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.load.front_image    = 'success'
                this.message.front_image = 'Sparat!'
            }).catch(() => {
            }).finally(() => {
                this.loading = false;
            })
        },
        'form.background_image': function ($value, $old_value) {
            if (this.loading) {
                return;
            }
            this.load.background_image = true;
            let data                   = new FormData();
            data.append('background_image', $value, 'background_image');
            axios(
                "/loehk/active_year/" + this.active_year.id + "/update",
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    data: data,
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'multipart/form-data',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.load.background_image    = 'success'
                this.message.background_image = 'Sparat!'
            }).catch(() => {
            }).finally(() => {
                this.loading = false;
            })
        },
        'form.group_photo': function ($value, $old_value) {
            if (this.loading) {
                return;
            }
            this.load.group_photo = true;
            let data              = new FormData();
            data.append('group_photo', $value, 'group_photo');
            axios(
                "/loehk/active_year/" + this.active_year.id + "/update",
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    data: data,
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'multipart/form-data',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.load.group_photo    = 'success'
                this.message.group_photo = 'Sparat!'
            }).catch(() => {
            }).finally(() => {
                this.loading = false;
            })
        },
        'form.christmas_image': function ($value, $old_value) {
            if (this.loading) {
                return;
            }
            this.load.christmas_image = true;
            let data                  = new FormData();
            data.append('christmas_image', $value, 'christmas_image');
            axios(
                "/loehk/active_year/" + this.active_year.id + "/update",
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    data: data,
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'multipart/form-data',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.load.christmas_image    = 'success'
                this.message.christmas_image = 'Sparat!'
            }).catch(() => {
            }).finally(() => {
                this.loading = false;
            })
        },
    },
    data() {
        return {
            loading: true,
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
                created_at: '',
                updated_at: '',
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
        getLoad(type, id) {
            if (this.message[type][id]) {
                return this.message[type][id]
            }
            return false;
        },
        addNewYear() {
            axios(
                "/loehk/active_year/new",
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
                                'multipart/form-data',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.$set(this.all_years, this.all_years.length, res.data)
                this.active_year = res.data;
            }).catch(() => {
            }).finally(() => {
            })
        },
        updateCommitteeMember(id, fieldname, value, index) {
            if (value === undefined || value === null) {
                return;
            }
            let data = new FormData();
            if (fieldname === 'image') {
                data.append(fieldname, value, fieldname);
            } else {
                data.append(fieldname, value);
            }
            if (!id) {
                data.append('active_year_id', this.active_year.id);
            }
            this.$set(this.load.committee_member, id + fieldname, true)
            this.$set(this.message.committee_member, id + fieldname, '')
            axios(
                "/loehk/committee_member" + (id ? '/' + id : ''),
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    timeout: 3000,
                    data: data,
                    headers:
                        {
                            'Content-Type':
                                'multipart/form-data',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                if (!id) {
                    this.$set(this.active_year.committee_members, index, res.data)
                    this.$set(this.message.committee_member, res.data.id + fieldname, 'Success!')
                } else {
                    this.$set(this.message.committee_member, id + fieldname, 'Success!')
                }
            }).catch(() => {
            }).finally(() => {
                this.$set(this.load.committee_member, id + fieldname, false)
            })
        },
        deleteCommitteeMember(member, index) {
            this.$set(this.load.committee_member, member.id + 'delete', true)
            this.$set(this.message.committee_member, member.id + 'delete', '')
            axios(
                "/loehk/committee_member/" + member.id,
                {
                    method:
                        'delete',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'multipart/form-data',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.$set(this.message.committee_member, member.id + 'delete', false)
                this.active_year.committee_members.splice(index, 1);
            }).catch(() => {
            }).finally(() => {
                this.$set(this.load.committee_member, member.id + 'delete', false)
            })
        },
        getActiveYear() {
            axios(
                "/loehk/active_year",
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
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.active_year = res.data.current;
                this.all_years   = res.data.all_years;
            }).catch(() => {
            }).finally(() => {
                this.loading = false;
            })
        },
        saveDescription() {
            if (this.loading) {
                return;
            }
            this.load.description    = true;
            this.message.description = ''
            axios(
                "/loehk/active_year/" + this.active_year.id + "/update",
                {
                    method:
                        'post',
                    withCredentials:
                        true,
                    responseType:
                        'json',
                    data: JSON.stringify({'description': this.active_year.description}),
                    timeout: 3000,
                    headers:
                        {
                            'Content-Type':
                                'application/json',
                            'Accept':
                                'application/json',
                        },
                }).then(res => {
                this.load.description    = 'success'
                this.message.description = 'Sparat!'
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
