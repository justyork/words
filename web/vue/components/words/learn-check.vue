<template>
    <div class="" v-touch:swipe="swipeHandler">

        <div class="ui center aligned segment"  v-if="words.length && !skipWordLoading">
            <h2>
                <a @click="speak(words[activeNum].word)"><i class="volume up icon"></i></a>
                {{words[activeNum].word}}
            </h2>
            <div class="ui horizontal divider">
                <i class="icon line"></i>
            </div>
            <h2>{{words[activeNum].translate}}</h2>
        </div>
        <div class="" v-else-if="skipWordLoading">
            <div class="ui active inverted dimmer">
                <div class="ui text loader">Loading</div>
            </div>
            <p></p>
        </div>
        <div class="learn-skip">
            <a href="#" class="ui mini blue button " @click="skip">Заменить</a>
        </div>

        <div class="word-buttons">
            <div class="fluid ui buttons">
                <a @click="prev" href="javascript:;" class="ui massive blue button">НАЗАД</a>
                <a @click="next" href="javascript:;" class="ui massive teal button">ВПЕРЕД</a>
            </div>
        </div>
    </div>
</template>

<script>
    import config from '../../config.js'
    var synth = window.speechSynthesis;
    module.exports = {
        props: ['pack_id',],
        data: function () {
            return {
                wordsApiLink: 'pack/',
                skipWordApiLink: 'pack/skip-word',

                words: [],
                activeNum: 0,
                skipWordLoading: false,
            }
        },
        computed:{
        },
        methods: {
            loadWords(){
                this.$http.get(config.API_LOCATION + this.wordsApiLink + this.pack_id + '').then(response => {
                    if(response.status)
                        this.words = response.body;
                })
            },
            swipeHandler(direction){
                if(direction === 'left') this.next()
                else this.prev();

            },
            prev(){
                if(this.activeNum === 0) this.activeNum = this.words.length - 1;
                else this.activeNum--;
            },
            next(){
                if(this.activeNum === this.words.length - 1) this.activeNum = 0;
                else this.activeNum++;
            },
            skip(){
                this.skipWordLoading = true;
                let data = new FormData()
                data.append('word_id', this.words[this.activeNum].id)
                data.append('pack_id', this.pack_id)
                this.$http.post(config.API_LOCATION + this.skipWordApiLink, data ).then(response => {
                    if(response.status){
                        this.words[this.activeNum] = response.data;
                        var oldNum = this.activeNum;
                        this.activeNum = 0;
                        this.activeNum = oldNum;
                        this.skipWordLoading = false;
                    }
                })
            },
            speak(word){
                var utterThis = new SpeechSynthesisUtterance(word);
                utterThis.onend = function (event) {
                    console.log('SpeechSynthesisUtterance.onend');
                }
                utterThis.onerror = function (event) {
                    console.error('SpeechSynthesisUtterance.onerror');
                }

                utterThis.voice = this.getVoice();
                utterThis.pitch = 1;
                utterThis.rate = 0.7;

                synth.speak(utterThis);
            },
            getVoice(){
                var voices = synth.getVoices()
                voices.forEach(function (val, index) {
                    if(val.lang == 'de-DE'){
                        return val
                    }
                })
            },
        },
        created: function () {
            this.loadWords()

        }
    }
</script>
