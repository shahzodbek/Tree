<template>
    <load :status="loading" @upload="uploadTree">
        <div class="example-description" >
            <input type="text" placeholder="Type to filter..." v-model="filter" class="filter-field form-control">
        </div>
        <liquor-tree
            :data="tree"
            :options="options"
            ref="tree"
            :filter="filter"
            @node:dragging:finish="logDragFinish"
        >
            <div slot-scope="{ node }" class="node-container">
                <div class="node-text">
                    {{ node.text }}
                </div>
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                    <button type="button" class="btn btn-outline-primary" @click.stop="addChildNode(node)"><i class="bi bi-node-plus"></i></button>
                    <button type="button" class="btn btn-outline-primary" @click.stop="editNode(node)"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" class="btn btn-outline-primary" @click.stop="removeNode(node)"><i class="bi bi-node-minus"></i></button>
                </div>
            </div>
        </liquor-tree>
    </load>
</template>

<script>
import Load from './loader/Load'
import LiquorTree from 'liquor-tree'
export default {
    name: 'Tree',
    data () {
        return {
            options: {
                checkbox: false,
                dnd: true
            },
            loading: 'load',
            filter: ''
        }
    },
    components: {
        LiquorTree,
        Load
    },
    methods: {
        logDragFinish (targetNode, destinationNode, status) {
            var data = {
                targetNodeId: targetNode.id,
                destinationNodeId: destinationNode.id,
                status: status,
                data:{id:targetNode.id}
            }
            this.$store.dispatch('updateNodePosition', data).then(resolve => {
            }).catch(reject => {
                console.log(reject)
            })
        },
        editNode (node, e) {
            node.startEditing()
            this.$refs.tree.$on('node:editing:stop', (node, prevNodeText) => {
                this.$store.dispatch('updateNodeText', { text: node.text, id: node.data.id }).then(resolve => {
                }).catch(reject => {
                    node.text = prevNodeText
                    console.log(reject)
                })
            })
        },
        removeNode (node) {
            if (confirm('Are you sure?')) {
                this.$store.dispatch('removeNode', { nodeId: node.data.id }).then(resolve => {
                    node.remove()
                }).catch(reject => {
                    console.log(reject)
                })
            }
        },
        addChildNode (node) {
            this.$store.dispatch('addChildNode', { parentId: node.data.id }).then(resolve => {
                console.log(resolve.data)
                node.append(resolve.data)
            }).catch(reject => {
                console.log(reject)
            })
        },
        uploadTree () {
            this.loading = 'load'
            this.$store.dispatch('fetchTree').then(() => {
                this.loading = 'success'
            }).catch(() => {
                this.loading = 'reload'
            })
        }
    },
    computed: {
        tree: {
            get () {
                return this.$store.state.tree
            },
            set (val) {
                //  this.$store.commit('UPDATE_TREE', val)
            }
        }
    },
    created () {
        this.uploadTree()
    }
}
</script>
