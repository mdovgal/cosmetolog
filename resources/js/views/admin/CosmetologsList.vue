<template>
    <div class="users">
        <h5>Косметологічний розділ у розробці</h5>
    </div>
</template>
<script>
    import Vue from 'vue';
    import M from 'materialize-css';
    import 'materialize-css/dist/css/materialize.min.css';
    import axios from 'axios';
    import JQuery from 'jquery';
    let $ = JQuery;

    export default {
        mounted(){
            setTimeout(() => {
                $("menu a").each(function(){
                    if($(this).hasClass('active')) $(this).removeClass('active');
                });
            var current_menu_item = $("#cosmetolog_section");
console.log('~~> current_menu_item ~~~', current_menu_item);
            if(!current_menu_item.hasClass('active'))current_menu_item.addClass('active');
console.log('~~> current_menu_item ~~~', $("#general_loader"));
            $("#general_loader").hide();
        }, 50);
    }
    }
</script>
<style>
    .add_author{text-align: end;margin: 17px 0px;}
</style>