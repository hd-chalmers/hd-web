<template>
        <game-list/>
</template>
    <script lang="ts">
        import {Vue, Component} from "vue-property-decorator";
        import GameList from "@/views/game/GameList.vue";

        @Component({
            components: {GameList}
        })
        export default class GamePage extends Vue{
        }
    </script>
