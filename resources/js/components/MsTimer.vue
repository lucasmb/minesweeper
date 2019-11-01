<template>
    <div class="row">
        <span class="timer"> {{ time }}</span>
    </div>

</template>

<script>
    export default {
        name: "MsTimer",
        props: { run: {}, stopped: {}, }  ,
        data() {
            return {
                time: "00:00:00 0000",
                timeStopped: false,
                stoppedDuration: 0,
                running: false,
                timeBegan: null,
                started: 0,
                minutes: 0,
                hours: 0,
            }
        },
        methods: {
            start() {

                console.log('start time');
                if(this.running)
                    return;

                if (this.timeBegan === null) {
                    this.reset();
                    this.timeBegan = new Date();
                }

                if (this.timeStopped !== null) {
                    this.stoppedDuration += (new Date() - this.timeStopped);
                }

                this.started = setInterval(this.clockRunning, 10);
                this.running = true;
            },

            stop() {
                this.running = false;
                this.timeStopped = new Date();
                clearInterval(this.started);
            },
            reset() {
                this.running = false;
                clearInterval(this.started);
                this.stoppedDuration = 0;
                this.timeBegan = null;
                this.timeStopped = null;
                this.time = "00:00:00.000";
            },
            clockRunning(){
                let currentTime = new Date()
                    , timeElapsed = new Date(currentTime - this.timeBegan - this.stoppedDuration)
                    , hour = timeElapsed.getUTCHours()
                    , min = timeElapsed.getUTCMinutes()
                    , sec = timeElapsed.getUTCSeconds()
                    , ms = timeElapsed.getUTCMilliseconds();

                this.time =
                    this.zeroPrefix(hour, 2) + ":" +
                    this.zeroPrefix(min, 2) + ":" +
                    this.zeroPrefix(sec, 2) + "." +
                    this.zeroPrefix(ms, 3);
            },

            zeroPrefix(num, digit) {
                var zero = '';
                for(var i = 0; i < digit; i++) {
                    zero += '0';
                }
                return (zero + num).slice(-digit);
            }

        },
        watch: {
            run: function(rVal) {
                if(rVal){
                    console.log('start: '+rVal);

                    this.reset();
                    this.start();
                }
            },
            stopped: function(sVal ) {
                if(sVal){
                    this.stop(); console.log('stop: '+sVal);
                }
            }
        }

    }

</script>

<style scoped>

    .timer {
        font-size: 20px;
    }
</style>
