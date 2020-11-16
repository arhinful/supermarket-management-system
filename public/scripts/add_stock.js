
$(function () {

    $('#create_payment_method').change(function (e) {
        let payment_method = $(this).val()
        let price = $('#create_price')
        if(payment_method === 'manual'){
            price.prop('disabled', true)
        }
        else {
            price.prop('disabled', false)
        }
    })

    // perform search for create new drug/stock
    let create__list = []
    let update__list = []
    $('#create_name').keyup(function () {
        let _text = $(this).val()
        if (_text !== ''){
            axios.post('/search', {
                _text: _text,
            })
                .then(function (response) {
                    if (response.data.length !== 0){
                        let container = $('#create_list_group')
                        let data = response.data
                        data.forEach(function (item) {
                            if (!create__list.includes(item.id)){
                                container.append(
                                    '<li class="text-center mb-2">\n' +
                                        '<a href="#" class="create_search_list">'+ item.name +'</a>\n' +
                                    '</li>'
                                )
                                create__list.push(item.id)
                            }
                        })


                    }

                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        if (_text.length === 0){
            $('#create_list_group').hide()
            //create__list.pop()
        }
        else {
            $('#create_list_group').show()
        }

        $("#create_list_group li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(_text.toLowerCase()) > -1)
        });

    })
    // end search perform

    // perform search for update drug/stock

    // $('#update_name').keyup(function () {
    //
    //     let _text = $(this).val()
    //     if (_text !== ''){
    //         axios.post('/search', {
    //             _text: _text,
    //         })
    //             .then(function (response) {
    //                 if (response.data.length !== 0){
    //                     let container = $('#update_list_group')
    //                     let data = response.data
    //                     data.forEach(function (item) {
    //
    //                         if (!update__list.includes(item.id)){
    //                             function update_link_click(e) {
    //                                 console.log('click')
    //                             }
    //                             container.append(
    //                                 '<li class="text-center mb-2">\n' +
    //                                 '<a href="#" id="update'+item.id+'" class="update_search_list">'+ item.name +'</a>\n' +
    //                                 '</li>'
    //                             )
    //                             update__list.push(item.id)
    //                         }
    //                     })
    //
    //
    //                 }
    //
    //             })
    //             .catch(function (error) {
    //                 console.log(error);
    //             });
    //     }
    //
    //     if (_text.length === 0){
    //         $('#update_list_group').hide()
    //         //create__list.pop()
    //     }
    //     else {
    //         $('#update_list_group').show()
    //     }
    //
    //     $("#update_list_group li").filter(function() {
    //         $(this).toggle($(this).text().toLowerCase().indexOf(_text.toLowerCase()) > -1)
    //     });
    //
    // })
    // end search perform

})
