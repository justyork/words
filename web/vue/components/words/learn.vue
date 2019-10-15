<template>
    <div class="learn">
        <div class="learn-tip" v-if="hasAnswer">
            <a href="javascript:;" @click="tipForm = true" v-if="!tipForm">Add tip</a>
            <div v-if="tipForm">
                <input type="text" v-model="tipText">
                <button @click="saveTip" class="">OK</button>
            </div>
        </div>
        <div v-if="words.length && only_new == 1" class="learn-series">
            <span :class="'ui '+seriesColor(words[0])+' horizontal label'">{{seriesStat(words[0])}}</span>
        </div>
        <div class="learn__item" v-if="words.length">
            <div class="learn__item-word">
                {{word}}
            </div>
            <div class="learn__item-translate" v-if="hasAnswer">
                {{translate}}
            </div>

            <div class="learn__item-tip" v-if="hasAnswer">
                {{words[0].tip}} &nbsp;
            </div>
        </div>

        <div class="learn-button">
            <div class="learn-button__start fluid ui buttons" v-if="wordStatus == 0">
                <a @click="know(false)" href="javascript:;" class="ui massive red button">DON'T KNOW</a>
                <a @click="know(true)" href="javascript:;" class="ui massive teal button">KNOW IT</a>
            </div>
            <div class="learn-button__know fluid ui buttons" v-if="wordStatus == 1">
                <a @click="correct(false)" href="javascript:;" class="ui massive red button">NOT CORRECT</a>
                <a @click="correct(true)" href="javascript:;" class="ui massive teal button">CORRECT</a>
            </div>
            <div class="learn-button__dontknow fluid ui buttons" v-if="wordStatus == 2">
                <a @click="correct(false)" href="javascript:;" class="ui massive blue button">NEXT</a>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: [
            'pack_id',
            'type',
            'repeat',
            'only_new',
            'rep',
        ],
        data: function () {
            return {
                apiUrl: '/api/',
                words: [],
                activeNum: 0,
                wordStatus: 0,
                isCorrect: false,
                hasAnswer: false,
                lastPosition: 0,
                halfPosition: 0,
                randomPos: -1,
                tipForm: false,
                tipText: '',
            }
        },
        computed:{
            word(){
                return this.words[0].word;
            },
            translate(){
                return this.words[0].translate;
            }
        },
        methods: {
            seriesStat(model){
                return model.series+' / '+model.series_need;
            },
            seriesColor(model){
                let color = '';
                if(model.series_need === 2){
                    if(model.series === 0) color = 'red';
                    if(model.series === 1) color = 'orange';
                    if(model.series >= 2) color = 'teal';
                }
                if(model.series_need === 3){
                    if(model.series === 0) color = 'red';
                    if(model.series === 1) color = 'orange';
                    if(model.series === 2) color = 'yellow';
                    if(model.series >= 3) color = 'teal';
                }
                return color;
            },
            getWords(){

                let url = this.repeat ? 'repeat-words' : 'words-by-pack?id='+this.pack_id+'&type='+this.type+'&only_new='+this.only_new
                this.$http.get(this.apiUrl+url).then(response => {
                    if(response.status){
                        this.words = response.body;
                        this.lastPosition = this.words.length - 1;
                        this.halfPosition = Math.ceil((this.words.length - 1) / 2)
                    }
                })
            },
            nextWord(pos){
                this.words = this.move(this.words, pos);
                this.hasAnswer = false;
                this.isCorrect = false;
                this.wordStatus = 0;
                this.randomPos = -1;
                // console.log(this.words);
            },
            know(isTrue){
                this.hasAnswer = true;
                if(isTrue)
                    this.wordStatus = 1;
                else{
                    this.wordChecked(false);
                    this.wordStatus = 2;
                }
            },
            correct(isTrue){
                var pos = this.lastPosition;
                this.words[0].series++;
                if(!isTrue){
                    pos = this.halfPosition;
                    this.words[0].series = 0;
                }
                this.wordChecked(isTrue);
                this.nextWord(pos);
            },
            move(arr, new_index) {
                var old_index = 0;
                if (new_index >= arr.length) {
                    var k = new_index - arr.length + 1;
                    while (k--) {
                        arr.push(undefined);
                    }
                }
                arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
                return arr; // for testing
            },
            saveTip(){
                let data = new FormData();
                data.append('tip', this.tipText);
                data.append('word_id', this.words[0].id);
                this.$http.post(this.apiUrl+'add-word-tip', data ).then(response => {
                    if(response.status){
                        this.tipForm = false;
                        this.words[0].tip = this.tipText;
                    }
                })
            },
            wordChecked(correct){
                let data = new FormData();
                data.append('word_id', this.words[0].id);
                data.append('correct', correct ? 1 : 0);
                data.append('type', this.words[0].type);
                data.append('level', this.words[0].level);
                data.append('repeat', this.repeat);
                this.$http.post(this.apiUrl+'check-word', data )
            },
        },
        created: function () {
            if(!this.type) this.type = 'ab';
            this.getWords()
            console.log(this.repeat)
        }
    }
</script>
