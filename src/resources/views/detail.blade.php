<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ラジオでモーダル切り替え</title>
    <style>
        /* ラジオボタン非表示 */
        input[type="radio"] {
            display: none;
        }

        /* モーダル共通スタイル */
        .modal-wrapper {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            min-width: 300px;
            text-align: center;
            position: relative;
            display: none;
        }

        .close-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            margin: 1rem;
            padding: 0.75rem 1.5rem;
            background-color: #333;
            color: white;
            cursor: pointer;
            border-radius: 0.5rem;
        }

        /* 表示切り替え */
        #modal-recommend:checked ~ .modal-wrapper {
            display: flex;
        }

        #modal-recommend:checked ~ .modal-wrapper .recommend-modal {
            display: block;
        }

        #modal-mylist:checked ~ .modal-wrapper {
            display: flex;
        }

        #modal-mylist:checked ~ .modal-wrapper .mylist-modal {
            display: block;
        }

        #modal-close:checked ~ .modal-wrapper {
            display: none;
        }
    </style>
</head>
<body>

    <!-- ラジオボタン（hidden） -->
    <input type="radio" name="modal" id="modal-recommend">
    <input type="radio" name="modal" id="modal-mylist">
    <input type="radio" name="modal" id="modal-close" checked>

    <!-- ボタン -->
    <div class="modal-trigger">
        <label for="modal-recommend" class="btn">おすすめを開く</label>
        <label for="modal-mylist" class="btn">マイリストを開く</label>
    </div>

    <!-- モーダル本体 -->
    <div class="modal-wrapper">
        <div class="modal recommend-modal">
            <p>おすすめ商品一覧</p>
            <label for="modal-close" class="close-btn">×</label>
        </div>

        <div class="modal mylist-modal">
            <p>マイリスト商品一覧</p>
            <label for="modal-close" class="close-btn">×</label>
        </div>
    </div>

</body>
</html>
