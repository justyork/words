<template>
    <div>

        <h2>Категория: {{categoryModel.title}} <span class="ui small label">{{categoryModel.count}}</span></h2>

        <div style="margin-bottom: 15px;">
            <a :href="'/word/index?id='+id" class="ui blue button " style="margin-bottom: 5px;"><i class="list icon"></i>Посмотреть слова</a>
            <button class="ui teal button " @click="showAddPack = !showAddPack"> <i class="add icon"></i> Добавить пачку</button>
        </div>

        <div class="ui form" style="margin-bottom: 15px;" v-if="showAddPack">
            <div class="ui card">
                <div class="content">
                    <div class="header">Добавить пачку</div>
                </div>

                <div class="content">
                    <div class="description">
                        <div class="field">
                            <label>Количество слов</label>
                            <input type="number" v-model="countWords">
                        </div>
                    </div>
                </div>
                <div class="extra content">
                    <button :disabled="loadingAddPackButton" :class="'ui button teal '+(loadingAddPackButton ? 'loading' : '')" @click="addPack">Добавить</button>
                </div>
            </div>
            <div class="ui divider"></div>
        </div>

        <div class="ui cards" v-if="categoryModel">
            <div :class="'card ' + (item.learned.all ? 'teal' : '')" v-for="item in categoryModel.packs">
                <a class="ui red mini right corner label" @click="openDeletePackModal(item.id)">
                    <i class="icon  trash alternate outline"></i>
                </a>
                <div class="content">


                    <a :href="item.url.check" style="margin-top: 5px;" class="header">Пачка №{{item.id}}</a>
                    <div class="meta">
                        <span class="right floated time">всего: {{item.count.total}}</span>
                        <span>{{item.date}}</span>
                    </div>
                    <div class="description">

                        <b>Выучено:</b>
                        <div class="ui two column grid">
                            <div class="column">Cлово: {{item.count.learned.a}}</div>
                            <div class="column right aligned">Перевод: {{item.count.learned.b}}</div>
                        </div>
                    </div>
                </div>
                <div class="ui bottom attached three buttons">
                    <a :href="item.url.a+(item.learned.a ? '&rep' : '')" :class="'ui small button '+(item.learned.a ? 'teal' : 'blue')">
                        A-B
                    </a>
                    <a :href="item.url.r+(item.learned.all ? '&rep' : '')" :class="'ui small button '+(item.learned.all ? 'teal' : 'blue')">
                        случайно
                    </a>
                    <a :href="item.url.b+(item.learned.b ? '&rep' : '')" :class="'ui small button '+(item.learned.b ? 'teal' : 'blue')">
                        B-A
                    </a>
                </div>
            </div>
        </div>
        <div class="ui ignored warning message">
            <p><b>A-B</b> - Учить иностранное слово</p>
            <p><b>B-A</b> - Учить перевод</p>
        </div>
        <div id="delete-pack"  class="ui small basic test modal">
            <div class="ui icon header">
                <i class="trash icon"></i>
                Удалить пачку?
            </div>
            <div class="actions">
                <div class="ui red basic cancel inverted button">
                    <i class="remove icon"></i>
                    Нет
                </div>
                <div class="ui green ok inverted button" @click="deletePack(deletePackId)">
                    <i class="checkmark icon"></i>
                    Да
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import config from '../../config.js'
    module.exports = {
        props: ['id'],
        data: function () {
            return {
                categoryApiLink: 'categories/',
                addPackApiLink: 'pack/create',
                deletePackApiLink: 'pack/delete',

                categoryModel: false,
                countWords: 15,
                showAddPack: false,
                loadingAddPackButton: false,
                deletePackId: 0,
            }
        },
        methods: {
            loadCategory:function () {
                this.$http.get(config.API_LOCATION + this.categoryApiLink + this.id+'?expand=packs').then(response => {
                    if(response.status)
                        this.categoryModel = response.body;
                })
            },
            addPack:function () {
                this.loadingAddPackButton = true;

                let data = new FormData();
                data.append('count', this.countWords);
                data.append('category_id', this.id);
                this.$http.post(config.API_LOCATION + this.addPackApiLink, data ).then(response => {
                    if(response.status){
                        if(response.body == 'OK'){
                            this.loadingAddPackButton = false;
                            this.showAddPack = false;
                            this.loadCategory();
                        }
                    }
                })
            },
            openDeletePackModal:function(pack_id){
                this.deletePackId = pack_id;
                $('#delete-pack')
                    .modal('setting', 'closable', false)
                    .modal('show')
                ;
            },
            deletePack:function (id) {
                // if(!confirm("Удалить пачку?"))
                let data = new FormData();
                data.append('id', id);
                this.$http.post(config.API_LOCATION + this.deletePackApiLink, data ).then(response => {
                    if(response.status){
                        if(response.body == 'OK'){
                            this.loadCategory();
                        }
                    }
                })
            }
        },
        created: function () {
            this.loadCategory()
        }
    }
</script>

<style>
    .pack-actions{
        right: 0;
        top: 0;
        position: absolute;
    }
</style>