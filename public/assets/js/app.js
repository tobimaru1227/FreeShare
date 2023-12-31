
// 画像拡大表示用のモーダル(detail.blade.php)
    function showModal(image) {
        var modal = document.getElementById("modal");
        var modalImage = document.querySelector(".modal-image");

        modal.style.display = "flex";
        modalImage.src = image.src;
        modalImage.classList.add("expanded"); // 追加: 拡大表示用のクラスを追加
    }

    function hideModal() {
        var modal = document.getElementById("modal");
        var modalImage = document.querySelector(".modal-image");

        modalImage.classList.remove("expanded"); // 追加: 拡大表示用のクラスを削除
        modal.style.display = "none";
    }
            
// 投稿の確認ダイアログ
    function storeDialog(event) {
        event.preventDefault();
        if(window.confirm('投稿してもよろしいですか？')) {
            document.getElementById('tweet-form').submit();
        }
    }
    
// 更新の確認ダイアログ
    function updateDialog(event) {
        event.preventDefault();
        if(window.confirm('更新してもよろしいですか？')) {
            document.getElementById('update-form').submit();
        }
    }

// 削除の確認ダイアログ
    function deleteDialog(event) {
        event.preventDefault();
        if(window.confirm('削除してもよろしいですか？')) {
            document.getElementById('delete-form').submit();
        }
    }