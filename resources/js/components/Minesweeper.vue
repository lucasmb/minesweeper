<template>
        <div class="row">
            <div class="minesweeper-game">
                <game-settings :rows="rows" :cols="cols" :mines="mines" @startGame="gameStart"></game-settings>

                <div class="row">
                    <div class="card">
                    <div  v-if="started" class="board">
                        <div class="row"  v-for="(row, x) in board" :key="x">
                            <mine-cell :cell="cell" :gameover="gameover" v-for="(cell, y) in row" :row="x" :key="y"
                                       @multiReveal="multiReveal"
                                       @gameOver="finishGame">
                            </mine-cell>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <ms-timer :run="trun" :stopped="tstop"></ms-timer>
                </div>
            </div>

        </div>

</template>

<script>
    import MineCell from './MineCell.vue';
    import GameSettings from "./GameSettings.vue";
    import MsTimer from "./MsTimer.vue";

    export default {
        name: "minesweeper",
        components: {
            GameSettings,
            MineCell,
            MsTimer

        },
        data() {
            return {
                board: null,
                rows: 10,
                cols: 10,
                mines: 10,
                started: false,
                gameover:false,
                trun:false,
                tstop:true,
            }
        },

        methods: {
            gameStart(data){
                this.update(data)
                axios.get('/api/game/init', {
                    params: {
                        rows: rows.value,
                        cols: cols.value,
                        mines: mines.value
                    },
                })
                .then(response => {
                    this.started = true;
                    this.board = response.data.board;
                    this.trun=true;

                })
                .catch(error => {
                    console.log(error)
                });
            },
            update(data){
                this.rows=data.r;
                this.cols=data.c;
                this.mines=data.m;
                this.board=null;
                this.gameover=false;
                this.trun=false;
                this.tstop=true;

            },
            finishGame(){
                this.gameover=true;

                for(let i=0; i<this.rows; i++) {
                    for (let j = 0; j< this.cols; j++) {
                        this.board[i][j].revealed = true;
                    }
                }
                this.tstop = true;

            },
            multiReveal(cells){
                if(cells){
                    cells.forEach(function(el) {
                        console.log(el);
                        let cx=el[0]; let cy=el[1];
                        this.board[cx][cy].revealed = true;
                    }, this);
                }
                console.log(cells);
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped >
    .cell{
        border: solid 1px black;
        background: #8aabad;
        width: 40px;
        height: 40px;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
    }
</style>
