<template>
    <form>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Spel</h3>
                    <div class="form-group">
                        <label for="platform_select">Platform</label>
                        <select class="form-control" id="platform_select">
                            <option v-for="platform in platforms" :value="platform.id"
                                :selected="platform.id === game.game_platform.id"
                                >{{platform.name.charAt(0).toUpperCase() + platform.name.slice(1)}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <h3>Ägare</h3>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="owner_name">Namn</label>
                            <input type="text" class="form-control" id="owner_name" placeholder="Ägar Ägarsson">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="owner_nickname">Smeknamn</label>
                            <input type="text" class="form-control" id="owner_nickname" placeholder="Master">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="owner_email">Email</label>
                            <input type="email" class="form-control" id="owner_email" placeholder="owner@example.com">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="owner_phonenumber">Telefonnummer</label>
                            <input type="text" class="form-control" id="owner_phonenumber" placeholder="07xxxxxxxx">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        name: "edit-game",
        props: {
            platforms: {
                type: Array,
                required: true
            },
            game: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                form: {
                    game: {

                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
