<template>
    <div id="app" style="padding-bottom: 300px;">
        <h2>Custom Tree Item</h2>
        <div class="row">
            <div class="col-md-4">
                <div style="width:49%; display:inline-block; vertical-align: top;">
                    <v-jstree :data="data" v-model="data" :item-events="itemEvents" show-checkbox multiple allow-batch whole-row>
                        <template slot-scope="_">
                            <div style="display: inherit; width: 200px" @click.ctrl="customItemClickWithCtrl">
                                <i :class="_.vm.themeIconClasses" role="presentation" v-if="!_.model.loading"></i>
                                {{_.model.text}}
                                <button style="border: 0px; background-color: transparent; cursor: pointer;"
                                    @click="customItemClick(_.vm, _.model, $event)"><i
                                        class="fas fa-trash-alt"></i></button>
                                <button style="border: 0px; background-color: transparent; cursor: pointer;"
                                    @click="customItemClick(_.vm, _.model, $event)"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </template>
                    </v-jstree>
                </div>
            </div>
            <div class="col-md-8">
                <pre>{{data}}</pre>
            </div>
        </div>
    </div>
</template>

<script>
    import VJstree from 'vue-jstree'
    export default {
        name: 'app',
        data() {
            return {
                data_demo: {},
                editingItem: {},
                editingNode: null,
                itemEvents: {
                },
                data: [{
                        "text": "Same but with checkboxes",
                        "children": [{
                                "text": "initially selected",
                                "selected": true
                            },
                            {
                                "text": "custom icon",
                                "icon": "fa fa-warning icon-state-danger"
                            },
                            {
                                "text": "initially open",
                                "icon": "fa fa-folder icon-state-default",
                                "opened": true,
                                "children": [{
                                    "text": "Another node"
                                }]
                            },
                            {
                                "text": "custom icon",
                                "icon": "fa fa-warning icon-state-warning"
                            },
                            {
                                "text": "disabled node",
                                "icon": "fa fa-check icon-state-success",
                                "disabled": true
                            }
                        ]
                    },
                    {
                        "text": "Same but with checkboxes",
                        "opened": true,
                        "children": [{
                                "text": "initially selected",
                                "selected": true
                            },
                            {
                                "text": "custom icon",
                                "icon": "fa fa-warning icon-state-danger"
                            },
                            {
                                "text": "initially open",
                                "icon": "fa fa-folder icon-state-default",
                                "opened": true,
                                "children": [{
                                    "text": "Another node"
                                }]
                            },
                            {
                                "text": "custom icon",
                                "icon": "fa fa-warning icon-state-warning"
                            },
                            {
                                "text": "disabled node",
                                "icon": "fa fa-check icon-state-success",
                                "disabled": true
                            }
                        ]
                    },
                    {
                        "text": "And wholerow selection"
                    },
                    {
                        "text": "drag disabled",
                        "icon": "fa fa-warning icon-state-danger",
                        "dragDisabled": true
                    },
                    {
                        "text": "drop disabled",
                        "icon": "fa fa-warning icon-state-danger",
                        "dropDisabled": true
                    }
                ],
            }
        },
        methods: {
            itemClick(node) {
                this.editingNode = node
                this.editingItem = node.model
                console.log(node.model.text + ' clicked !')
            },
            removeNode: function () {
                if (this.editingItem.id !== undefined) {
                    var index = this.editingNode.parentItem.indexOf(this.editingItem)
                    this.editingNode.parentItem.splice(index, 1)
                }
            },
            customItemClick: function (node, item, e) {
                // e.stopPropagation()
                console.log("Node:");
                console.log("Item:");
                console.log(JSON.stringify(item));
                console.log("e:");
                console.log(JSON.stringify(e));
                var index = node.parentItem.indexOf(item)
                // node.parentItem.splice(index, 1)
            },
            customItemClickWithCtrl: function () {
                console.log('click + ctrl')
            },
        }
    }

</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }

    h1,
    h2 {
        font-weight: normal;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }

    div {
        display: block;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #EEE;
        font-size: 14px;
    }

    table th {
        background: #EEE;
        border-bottom: 1px solid #CCC;
        padding: 4px;
    }

    table td {
        border: 1px solid #EEE;
        padding: 4px;
    }

    .icon-state-default {
        color: gray;
    }

    .icon-state-danger {
        color: #DC0101;
    }

    .icon-state-warning {
        color: yellow;
    }

    .icon-state-success {
        color: green;
    }

</style>
