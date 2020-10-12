//post create popup
$(function() {
    $("#post-create-btn").on("click", function() {
        $(".popup")
            .addClass("show")
            .fadeIn();
        $(".sideber").hide();
    });

    $("#close").on("click", function() {
        $(".popup").fadeOut();
        $(".sideber").show();
    });
});
//post create popup---------------------------

//delete popup
$(function() {
    $(".delete-btn").on("click", function() {
        var delete_id = $(this).attr("id");
        var no = delete_id.substr(2);

        $("#delete-id" + no)
            .addClass("show-delete")
            .fadeIn();
        $(".sideber").hide();
    });

    $(".close-delete").on("click", function() {
        $(".popup-delete").fadeOut();
        $(".sideber").show();
    });
    //delete popup---------------------------
});

//vocabulary
$(function() {
    var menu = $(".vocabulary"), // スライドインするメニューを指定
        menuBtn = $(".sideber-vocabulary"), // メニューボタンを指定
        body = $(document.body),
        menuWidth = menu.outerWidth();
    closeBtn = $("#close-vocabulary");

    // メニューボタンをクリックした時の動き
    menuBtn.on("click", function() {
        // body に open クラスを付与する
        body.toggleClass("open");
        if (body.hasClass("open")) {
            // open クラスが body についていたらメニューをスライドインする
            menu.css("display", "block"); //要素の表示
            menu.animate({ right: 0 }, 300);
            $(".sideber").hide();
        } else {
            // open クラスが body についていなかったらスライドアウトする
            menu.animate({ right: -menuWidth }, 300);
            body.animate({ right: 0 }, 300);
            menu.css("display", "none"); //要素の非表示
            $(".sideber").show();
        }
    });

    var menu = $(".vocabulary"), // スライドインするメニューを指定
        menuBtn = $(".sideber-vocabulary"), // メニューボタンを指定
        body = $(document.body),
        menuWidth = menu.outerWidth();
    closeBtn = $("#close-vocabulary");

    // メニューボタンをクリックした時の動き
    closeBtn.on("click", function() {
        // body に open クラスを付与する
        body.toggleClass("open");
        if (body.hasClass("open")) {
            // open クラスが body についていたらメニューをスライドインする
            menu.css("display", "block"); //要素の表示
            menu.animate({ right: 0 }, 300);
            $(".sideber").hide();
        } else {
            // open クラスが body についていなかったらスライドアウトする
            menu.animate({ right: -menuWidth }, 300);
            body.animate({ right: 0 }, 300);
            menu.css("display", "none"); //要素の非表示
            $(".sideber").show();
        }
    });
});
//vocabulary----------------------------------

//ToPostのバリテーション
$(function() {
    $(".post-create-contents form").validate({
        rules: {
            post_ja: {
                required: true,
                minlength: {
                    param: 20
                },
                maxlength: {
                    param: 200
                }
            },
            post_en: {
                required: true,
                minlength: {
                    param: 20
                },
                maxlength: {
                    param: 200
                }
            }
        },
        messages: {
            post_ja: {
                required: "日記を入力して下さい",
                minlength: "20文字以上で入力しましょう",
                maxlength: "200文字以内で入力して下さい"
            },
            post_en: {
                required: "日記を入力して下さい",
                minlength: "20文字以上で入力しましょう",
                maxlength: "200文字以内で入力して下さい"
            }
        }
    });
});

//infinitescroll
// $(function() {
// var pageCount = {{ $timelines->lastPage() }};
// var nowPage = 1;
// $('.result_timelines').infinitescroll({
//     navSelector  : ".more",
//     nextSelector : ".more a",
//     itemSelector : ".info",
//     loading : {
//         img : '',
//         msgText : 'Now loading....',
//         finishedMsg : '',
//     },
// },
// function(newElements) {
//     var $newElems = $(newElements);
//     $("#infscr-loading").remove();
//     if (nowPage < pageCount) {
//         $(".more").appendTo(".result_timelines");  
//         $(".more").css({display: 'block'});  
//     }
//     nowPage++;
// });

// // クリックでスクロールさせるためinfinitescrollをunbind
// $('.result_timelines').infinitescroll('unbind');
// // クリック時の動作
// $('.more a').click(function(){
//     $('.result_timelines').infinitescroll('retrieve');
//     return false;
// });
}
