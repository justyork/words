<template>
    <div>
        <div class="chart">
<!--            <apexchart v-if="modelStat" height="100%" width="100%" type="bar" :options="options" :series="series"></apexchart>-->
        </div>
        <div class="ui cards">
            <div class="card">
                <div class="content ui aligned center">
                    <div v-if="countRepeatWords && countRepeatWords > 0">
                        <div class="ui labeled button">
                            <a href="/learn/repeat" class="ui teal button">
                                <i class="lightbulb outline icon"></i>
                                Повторить слова
                            </a>
                            <div class="ui basic label">
                                {{countRepeatWords}}
                            </div>
                        </div>
                        <div class="description" style="margin-top: 15px;">
                            Если вы выучили слово, оно попадает в список на повторение, чтобы вы могли его лучше запомнить
                        </div>
                    </div>
                    <div v-else-if="countRepeatWords === 0">
                        Молодец, у тебя нет слов для повторения!
                    </div>
                    <div v-else>
                        <div class="ui labeled button">
                            <button class="ui disabled teal button">
                                <i class="lightbulb outline icon"></i>
                                Повторить слова
                            </button>
                            <div class="ui basic label">
                                999
                            </div>
                        </div>
                        <div class="description" style="margin-top: 15px;">

                            <div class="ui placeholder">
                                <div class="paragraph">
                                    <div class="line"></div>
                                    <div class="line"></div>
                                    <div class="short line"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="card">
                <div class="content">
                    <div class="header">Ваши категории</div>
                    <div class="ui middle aligned selection list" v-if="modelCategories.length">
                        <div class="item" v-for="item in modelCategories">
                            <div class="right floated content" v-if="item.has_review">
                                <a :href="item.repeatUrl" class="ui button tiny icon float right">
                                    <i class="refresh icon" style="margin-left: 10px;"></i>
                                </a>
                            </div>
                            <div class="content">
                                <a :href="item.url" class="header" style="display: inline-block">
                                    {{item.title}}
                                    <div class="ui mini circular label">{{item.count}}</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="ui placeholder">
                            <div class="header">
                                <div class="line"></div>
                                <div class="line"></div>
                            </div>
                            <div class="paragraph">
                                <div class="short line"></div>
                                <div class="short line"></div>
                                <div class="short line"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/category/create" class="ui bottom attached teal button" v-if="modelCategories.length">
                    <i class="add icon"></i>
                    Добавить новую категорию
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import config from '../config.js'
    module.exports = {
        data: function () {
            return {
                categoryApiLink: 'categories',
                statApiLink: 'stat?sort=-date',
                countRepeatApiLink: 'learn/count-repeat-words',

                countRepeatWords: false,
                modelStat: [],
                modelCategories: [],
                options: {
                    chart: {
                        id: 'vuechart-example'
                    },
                    xaxis: {
                        categories: []
                    }
                },
                series: []

            }
        },
        methods: {
            loadStat: function () {
                this.$http.get(config.API_LOCATION + this.statApiLink).then(response => {
                    if(response.status){
                        this.modelStat = response.body;
                        this.fillChartData()
                    }
                })
            },
            loadCategories: function () {
                this.$http.get(config.API_LOCATION + this.categoryApiLink).then(response => {
                    if(response.status){
                        this.modelCategories = response.body;
                    }
                })
            },
            loadCountRepeatWords: function () {
                this.$http.get(config.API_LOCATION + this.countRepeatApiLink).then(response => {
                    if(response.status)
                        this.countRepeatWords = response.body;
                })
            },
            fillChartData: function () {
                var series = {
                    name: 'Кол-во слов',
                    data: []
                };
                var that = this
                this.modelStat.forEach(function (item) {
                    that.options.xaxis.categories.push(item.fdate);
                    series.data.push(item.count_words);
                })
                this.series.push(series)
            }
        },
        created: function () {
            this.loadStat();
            this.loadCategories();
            this.loadCountRepeatWords();
        }
    }
</script>

<style>
</style>