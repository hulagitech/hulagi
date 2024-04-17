
const firebaseConfig = {
    apiKey: "AIzaSyDZ0xkZKLRy2BJGsAUR7UE44SLG1FgjeXA",
    authDomain: "puryau-9383d.firebaseapp.com",
    projectId: "puryau-9383d",
    storageBucket: "puryau-9383d.appspot.com",
    messagingSenderId: "424016413383",
    appId: "1:424016413383:web:d37eaf2e875218bb5a74e2",
    measurementId: "G-63BDCG1W6L"
  };

  firebase.initializeApp(firebaseConfig);

  const messaging = firebase.messaging();

  messaging.requestPermission().then(function(){
      console.log('Notification Permission Granted');
      return messaging.getToken()
  }).then(function(response){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/store-token',
        type: 'POST',
        data: {
            token: response,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (response) {
        },
        error: function (error) {
        },
    });
  }).catch(function(err){
      console.log("Unable to get persmission.", err);
  });

  messaging.onMessage((payload)=>{
      console.log(payload);
      $('.noti-count').empty().html(payload.data['badge']);
      $('.comment-count').empty().html(payload.data['comment']);

      const title = payload.notification['title'];
      const options = {
        body: payload.notification['body'],
    };      
    new Notification(title, options);
  })