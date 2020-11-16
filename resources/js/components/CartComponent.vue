<template>

    <div>



        <v-navigation-drawer
            v-model="drawer"
            absolute
            temporary
            right
            width="400"
            id="drawer"
        >
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="green"
                        dark
                        small
                        top
                        absolute
                        right
                        class=""
                        @click="confirmPurchase"
                        id="confirm_purchase"
                        v-bind="attrs"
                        v-on="on"
                        :disabled="disableConfirm"
                    >
                        <v-icon>mdi-check</v-icon>
                    </v-btn>
                </template>
                <span>Confirm purchase</span>
            </v-tooltip>

            <v-container>
                <v-btn
                    color="pink"
                    dark
                    small
                    top
                    absolute
                    left
                    class="mr-5"
                    @click.stop="$destroy"
                >
                    <v-icon>mdi-arrow-right</v-icon>
                </v-btn>
            </v-container>

            <h3 style="text-align: center">
                Cart
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            color="red"
                            dark
                            small
                            @click="clearCart"
                            v-bind="attrs"
                            v-on="on"
                            class="ml-3"
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>
                    <span>Clear Cart</span>
                </v-tooltip>
            </h3>

            <div id="printThis">
                <v-list dense three-line>
                    <v-divider class="m-0"></v-divider>
                    <template v-for="(item) in items">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>
                                    <v-row no-gutters>
                                        <v-col cols="9"><b>{{item.item_name}}</b></v-col>
                                        <v-col cols="3">
                                            <v-tooltip bottom>
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-btn
                                                        text icon color="red lighten-2"
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        @click="remove_(item.id)"
                                                    >
                                                        <v-icon x-small>
                                                            fa-times
                                                        </v-icon>
                                                    </v-btn>
                                                </template>
                                                <span>Remove this item</span>
                                            </v-tooltip>
                                        </v-col>
                                    </v-row>
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    <v-row no-gutters>
                                        <v-col cols="6">Quantity</v-col>
                                        <v-col cols="6">{{item.quantity}}</v-col>
                                    </v-row>
                                </v-list-item-subtitle>
                                <v-list-item-subtitle>
                                    <v-row no-gutters>
                                        <v-col cols="6">Price</v-col>
                                        <v-col cols="6">{{item.price}}</v-col>
                                    </v-row>
                                </v-list-item-subtitle>
                                <v-list-item-subtitle>
                                    <v-row no-gutters>
                                        <v-col cols="6">Store Box</v-col>
                                        <v-col cols="6">{{item.store_box}}</v-col>
                                    </v-row>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider class="m-0 p-0"></v-divider>
                    </template>
                </v-list>


                <v-row no-gutters class="ml-5">
                    <v-col cols="6" >Total</v-col>
                    <v-col cols="6">GH Cedis <b>{{totalPrice}}</b></v-col>

                </v-row>
                <v-divider class="m-0"></v-divider>
            </div>

        </v-navigation-drawer>

    </div>
</template>

<script>
    export default {
        name: "cart",
        data: ()=>({
            drawer: true,
            items: [],
            totalPrice: 0,
            disableConfirm: true,
            print_: false,
            printObd: {
                id: 'printhis',
                popTitle: 'Print Report',
            }
        }),
        methods: {
            confirmPurchase(){
                axios.post('cart/confirm').then((res)=>{
                    if (res.data['success'] === 'true'){
                        this.$htmlToPaper('printThis');
                        this.fetchCart()
                        this.$emit('refreshItems')
                    }

                    // let this_btn = document.getElementById('confirm_purchase')
                    // this_btn.setAttribute('v-print', '#printThis')
                    // console.log(this_btn)
                    // // v-print="\'#printhis\'"
                })
                this.print_ = true
            },
            hideCart(){
                this.$emit('hideCart')
            },

            fetchCart(){
                axios.get('cart/all').then((res)=>{
                    this.items = res.data['carts'];
                    this.totalPrice = res.data['totalPrice']
                    if (res.data['carts'].length > 0){
                        this.disableConfirm = false
                    }
                    else {
                        this.disableConfirm = true
                    }
                })
            },

            clearCart(){
                axios.post('cart/clear').then((res)=>{
                    this.fetchCart()
                })
            },

            remove_(id){
                axios.post('cart/destroy', {id:id}).then((res)=>{
                    this.fetchCart()
                })
            }
        },
        created() {
            this.fetchCart()
        },
        destroyed() {
            this.hideCart()
        }
    }
</script>

<style scoped>

</style>
