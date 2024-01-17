$(function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    $(".todo-status-button").change(function () {
    //$(this) ::<input type="checkbox" class="form-control todo-status-button" name="id" value={{ $todo->content }} @if ($todo->is_completed) checked @endif>
      const content = $(this).val();//変更されたチェックボックスのタグ」のvalue属性の値を取得してcontent
      const url = $(this).parent(".todo-status-form").attr("action");//親要素にあたる「todo-status-form」というクラスが付けられた要素を取得し、そのaction属性の値を取得してurlに代入してい
        //{{ route('todo.complete', $todo->id) }}
      $.ajax(
        url,
        {
          type: 'POST',
          headers: { 'X-CSRF-TOKEN': csrfToken }//$ajax()という非同期通信をするための関数を使って、先ほど取得したurlにCSRFトークンをリクエストヘッダ（headers）に持たせてPOST通信をしている。
        }
      )
      .done(function(data) {//非同期がで成功したらdoneが実行される
        console.log(data);
        if (data.is_completed) {
          window.alert('「' + content + '」のToDoを完了にしました。');//data.is_completedがtrue、つまりToDoを完了した場合、あらかじめ取得していたToDoの内容が格納されているcontentの文字列と一緒に、完了したことをアラートで表示
        } else {
          window.alert('「' + content + '」のToDoの完了を取り消しました。');//data.is_completedがtrueではない、つまりToDoの完了が取り消された場合、contentの文字列と一緒に、完了が取り消されたことをアラートで表示
        }
      })
      .fail(function() {//通信の失敗時には下記のようにfail()関数が実行されます。処理内容としては、「通信に失敗しました。」とアラートで表示するようにしています。
        window.alert('通信に失敗しました。');
      });
    });
  });
  