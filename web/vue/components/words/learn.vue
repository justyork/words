<template>
    <div class="learn">
        <div class="ui center aligned segment"  v-if="words.length">
            <h2>{{word}}</h2>
            <div class="ui horizontal divider" v-if="hasAnswer">
                <i class="icon line"></i>
            </div>
            <h2  v-if="hasAnswer">{{translate}}</h2>
        </div>

        <div v-if="words.length && only_new == 1" class="learn-series">
            <span :class="'ui '+seriesColor(words[0])+' horizontal label'">{{seriesStat(words[0])}}</span>
        </div>

        <div class="word-buttons">
            <div class="learn-button__start fluid ui buttons" v-if="wordStatus == 0">
                <a @click="know(false)" href="javascript:;" class="ui massive red button">не знаю</a>
                <a @click="know(true)" href="javascript:;" class="ui massive teal button">знаю</a>
            </div>
            <div class="learn-button__know fluid ui buttons" v-if="wordStatus == 1">
                <a @click="correct(false)" href="javascript:;" class="ui massive red button">не верно</a>
                <a @click="correct(true)" href="javascript:;" class="ui massive teal button">верно</a>
            </div>
            <div class="learn-button__dontknow fluid ui buttons" v-if="wordStatus == 2">
                <a @click="correct(false)" href="javascript:;" class="ui massive blue button">дальше</a>
            </div>
        </div>

    </div>
</template>

<script>
    import config from '../../config.js'
    module.exports = {
        props: [
            'pack_id',
            'type',
            'repeat',
            'only_new',
            'rep',
            'category_id'
        ],
        data: function () {
            return {
                repeatApiLink: 'learn/repeat-words',
                wordsApiLink: 'pack/',
                wordCheckApiLink: 'word/check',

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
            loadWords(){
                let url = config.API_LOCATION;
                if(this.repeat == 1)  url += this.repeatApiLink+'?category_id='+this.category_id;
                else url += this.wordsApiLink+this.pack_id + '/' + this.type + '/' + this.only_new;

                this.$http.get(url).then(response => {
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
            wordChecked(correct){
                let data = new FormData();
                data.append('word_id', this.words[0].id);
                data.append('correct', correct ? 1 : 0);
                data.append('type', this.words[0].type);
                data.append('level', this.words[0].level);
                data.append('repeat', this.repeat);
                this.$http.post(config.API_LOCATION + this.wordCheckApiLink, data )
            },
        },
        created: function () {
            if(!this.type) this.type = 'a';
            this.loadWords()
        }
    }
</script>
