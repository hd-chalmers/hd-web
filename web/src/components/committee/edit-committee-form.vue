<template>
    <form :action="route" enctype="multipart/form-data" method="post" class="py-2" id="form">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="year">År</label>
                    <input name="year" type="number" min="2000" max="2050" class="form-control" id="year" placeholder="Året de gick på" v-model.number="form.year">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-4">
                Bakgrundsbild
                <div class="custom-file mt-1">
                    <input type="file" name="background_image" class="custom-file-input" id="background" @change="saveBG"
                           accept="image/jpeg, image/png">
                    <label class="custom-file-label" for="background">
                        <template v-if="form.background !== ''">
                            {{form.background}}
                        </template>
                        <template v-else>
                            Byt Bakgrundsbild
                        </template>
                    </label>
                </div>
            </div>
            <div class="col-4">
                Gruppbild
                <div class="custom-file mt-1">
                    <input type="file" class="custom-file-input" name="group_photo" id="group_image" @change="saveGP"
                           accept="image/jpeg, image/png">
                    <label class="custom-file-label" for="group_image">
                        <template v-if="form.group_photo !== ''">
                            {{form.group_photo}}
                        </template>
                        <template v-else>
                            Byt Gruppbild
                        </template>
                    </label>
            </div>
        </div>
        <div class="col-4">
            Frontbild
            <div class="custom-file mt-1">
                <input type="file" class="custom-file-input" id="front_image" name="front_image" @change="saveFI"
                       accept="image/jpeg, image/png">
                <label class="custom-file-label" for="front_image">
                    <template v-if="form.front_image !== ''">
                        {{form.front_image}}
                    </template>
                    <template v-else>
                        Byt Frontbild
                    </template>
                </label>
            </div>
        </div>
        </div>
        <div class="form-row">
            <div class="col-12">
                <div class="form-group">
                    <label for="description">Beskrivning</label>
                    <textarea class="form-control" id="description" placeholder="" name="description" v-model.number="form.description"></textarea>
                </div>
            </div>
        </div>
        <h4>Redigera Medlemmar</h4>
        <a href="#" @click.prevent.stop="addNewMember">
            <span class="mdi mdi-account-plus"></span> Lägg till
        </a>
        <template v-for="(member, i) in form.members">
            <input hidden type="text" :name="'member['+i+'][id]'" :value="member.id">
            <hr>
            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        <label :for="'member-'+member.id+'-name'" class="sr-only">Namn</label>
                        <input type="text" class="form-control" :name="'member['+i+'][name]'" required :id="'member-'+i+'-name'" placeholder="Namn" v-model.number="member.name">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label :for="'member-'+i+'-role'" required class="sr-only">Post</label>
                        <input type="text" class="form-control" :name="'member['+i+'][role]'" :id="'member-'+i+'-role'" placeholder="Post" v-model.number="member.role">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label :for="'member-'+i+'-quote'" class="sr-only">Citat</label>
                        <input type="text" class="form-control" :name="'member['+i+'][quote]'" :id="'member-'+i+'-quote'" placeholder="Citat" v-model.number="member.quote">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        <label :for="'member-'+i+'-desc'" class="sr-only">Beskrivning</label>
                        <input type="text" class="form-control" :name="'member['+i+'][description]'" :id="'member-'+i+'-desc'" placeholder="Beskrivning" v-model.number="member.description">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label :for="'member-'+i+'-game'" class="sr-only">Favoritspel</label>
                        <input type="text" :name="'member['+i+'][favourite_game]'" class="form-control" :id="'member-'+i+'-game'" placeholder="Favoritspel" v-model.number="member.favourite_game">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label :for="'member-'+i+'-sugar'" class="sr-only">Socker of Choice</label>
                        <input type="text" :name="'member['+i+'][favourite_sugar]'" class="form-control" :id="'member-'+i+'-sugar'" placeholder="Socker of Choice" v-model.number="member.favourite_sugar">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" :id="'member-'+i+'-image'"
                               accept="image/jpeg, image/png" :name="'member['+i+'][image]'">
                        <label class="custom-file-label" :for="'member-'+i+'-image'">Byt Bild</label>
                    </div>
                </div>
            </div>
        </template>
        <button class="btn btn-primary mt-3" type="submit">Spara</button>
    </form>
</template>

<script>
    export default {
        name    : "edit-committee-form",
        props   : {
            route           : {
                type    : String,
                required: true
            },
            active_year_prop: {
                type    : Object,
                required: true
            },
            errors          : {
                type    : Array,
                required: false
            }
        },
        created() {
            this.form.year        = this.active_year_prop.year;
            this.form.description = this.active_year_prop.description;
            this.form.members     = this.active_year_prop.committee_members
        },
        computed: {
            len() {
                return this.form.members.length
            }
        },
        data() {
            return {
                csrf  : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                form  : {
                    year       : 2020,
                    description: "",
                    background : "",
                    front_image: "",
                    group_photo: "",
                    members    : []
                },
                member: {
                    name           : "",
                    role           : "",
                    description    : "",
                    favourite_game : "",
                    favourite_sugar: "",
                    quote          : "",
                    photo          : "",
                    id             : null
                }
            }
        },
        methods : {
            addNewMember() {
                this.form.members.push([
                    {
                        name           : "",
                        role           : "",
                        description    : "",
                        favourite_game : "",
                        favourite_sugar: "",
                        quote          : "",
                        photo          : "",
                        id             : null
                    }
                ])
            },
            saveBG(event) {
                this.form.background = (event.target.files[0].name)
            },
            saveGP(event) {
                this.form.group_photo = (event.target.files[0].name)
            },
            saveFI(event) {
                this.form.front_image = (event.target.files[0].name)
            }
        }
    }
</script>

<style scoped>

</style>
