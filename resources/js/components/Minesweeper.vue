<template>
        <div class="row">
            <div class="minesweeper-game">
                <game-settings :rows="rows" :cols="cols" :mines="mines" @startGame="gameStart"></game-settings>
                <div  v-if="start" class="board">
                    BOARD
                </div>
            </div>
        </div>
</template>

<script>
    import GameSettings from "./GameSettings.vue";

    export default {
        name: "minesweeper",
        components: {
            GameSettings,
        },
        data() {
            return {
                board: null,
                rows: 10,
                cols: 10,
                mines: 10,
                start: false,
                gameover:false,
            }
        },
        gameStart(data){
            this.start = true;
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
