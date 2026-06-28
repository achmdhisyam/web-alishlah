<?php 
use App\Models\Nav_model;
use App\Models\Konfigurasi_model;
$m_menu         = new Nav_model();
$nav_profil     = $m_menu->profil('Profil');
if (!isset($m_site)) {
    $m_site = new Konfigurasi_model();
}
$site_setting   = $m_site->listing();
?>
<style type="text/css" media="screen">
  /* Add your custom styles here */
.whatsapp-link {
    position: fixed;
    bottom: 35px;
    right: 105px;
    z-index: 9999;
    transition: transform 0.3s ease-in-out;
}
a.whatsapp-link {
    color: #fff;
    background-color: #25D366;
    border: none;
    border-radius: 50%;
    padding: 0;
    height: 60px;
    width: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    text-decoration: none;
}
a.whatsapp-link i {
    font-size: 2rem;
}
.whatsapp-link:hover {
    transform: scale(1.1);
}

/* Chatbot Styles */
.chatbot-toggler {
    position: fixed;
    bottom: 35px; /* Sejajar dengan WhatsApp */
    right: 35px;
    outline: none;
    border: none;
    height: 60px;
    width: 60px;
    display: flex;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #00ac37ff; /* Info color */
    color: #fff;
    transition: all 0.2s ease;
    z-index: 9999;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.chatbot-toggler:hover {
    transform: scale(1.1);
}
.chatbot-toggler i {
    font-size: 1.5rem;
    position: absolute;
    transition: opacity 0.2s ease, transform 0.2s ease;
}
.chatbot-toggler .fa-times {
    opacity: 0;
    transform: scale(0);
}
.show-chatbot .chatbot-toggler .fa-robot,
.show-chatbot .chatbot-toggler .chatbot-icon-img {
    opacity: 0;
    transform: scale(0);
}
.show-chatbot .chatbot-toggler .fa-times {
    opacity: 1;
    transform: scale(1);
}

.chatbot-wrapper {
    position: fixed;
    right: 35px;
    bottom: 105px;
    width: 300px;
    max-width: 85vw; /* Responsif di layar kecil */
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    opacity: 0;
    pointer-events: none;
    transform: scale(0.5);
    transform-origin: bottom right;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    transition: all 0.2s ease;
    z-index: 9999;
    border: 1px solid #ddd;
    display: flex;
    flex-direction: column;
}
.show-chatbot .chatbot-wrapper {
    opacity: 1;
    pointer-events: auto;
    transform: scale(1);
}
.chatbot-header {
    padding: 10px 15px;
    background: #00ac37;
    color: #fff;
    position: relative;
    text-align: center;
}
.chatbot-header h2 {
    color: #fff;
    font-size: 0.8rem;
    margin: 0;
    font-weight: bold;
}
.chatbot-body {
    height: 320px;
    max-height: 50vh; /* Responsif tinggi layar */
    overflow-y: auto;
    padding: 15px;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
}
.chatbot-body .chat {
    display: flex;
    margin-bottom: 15px;
}
.chatbot-body .chat p {
    margin: 0;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 0.72rem;
    line-height: 1.4;
    word-wrap: break-word;
    max-width: 80%;
}
.chatbot-body .chat-incoming p {
    background: #fff;
    color: #333;
    border: 1px solid #eee;
    border-top-left-radius: 0;
}
.chatbot-body .chat-outgoing {
    justify-content: flex-end;
}
.chatbot-body .chat-outgoing p {
    background: #00ac37;
    color: #fff;
    border-top-right-radius: 0;
}
.chatbot-footer {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    background: #fff;
    border-top: 1px solid #eee;
}
.chatbot-footer-inner {
    display: flex;
    width: 100%;
    align-items: center;
    background: #f1f3f5;
    border-radius: 20px;
    padding: 4px 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease-in-out;
}
.chatbot-footer-inner:focus-within {
    border-color: #00ac37;
    box-shadow: 0 0 6px rgba(0, 172, 55, 0.3);
    background: #fff;
}
.chatbot-footer textarea {
    height: 20px;
    line-height: 20px;
    max-height: 80px;
    width: 100%;
    border: none;
    outline: none;
    resize: none;
    padding: 0;
    font-size: 0.75rem;
    background: transparent;
    overflow-y: auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}
.chatbot-footer textarea::-webkit-scrollbar {
    display: none; /* Safari and Chrome */
}
.chatbot-footer button {
    background: transparent;
    border: none;
    color: #00ac37;
    font-size: 1rem;
    cursor: pointer;
    padding: 0 0 0 8px;
    transition: all 0.2s ease;
}
.chatbot-footer button:hover {
    color: #008a2c;
    transform: scale(1.1);
}
 
.quick-replies {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 8px;
    padding: 8px 16px;
    margin-bottom: 4px;
    background: transparent;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE and Edge */
}
.quick-replies::-webkit-scrollbar {
    display: none; /* Chrome, Safari and Opera */
}
.quick-reply-btn {
    background: transparent;
    border: 1px solid #ddd;
    border-radius: 15px;
    padding: 4px 10px;
    font-size: 0.65rem;
    color: #555;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    white-space: nowrap;
    flex-shrink: 0;
    outline: none;
}
.quick-reply-btn:hover {
    background: #00ac37;
    color: #fff;
    border-color: #00ac37;
    transform: translateY(-1px);
}
 
/* Responsive adjustments for Desktop (height stretch) & Mobile (centered) */
@media (min-width: 768px) {
    .chatbot-wrapper {
        height: 600px;
        max-height: calc(100vh - 150px);
        width: 320px;
    }
    .chatbot-body {
        flex: 1;
        height: auto;
        max-height: none;
    }
}

@media (max-width: 767px) {
    .chatbot-wrapper {
        right: auto;
        bottom: auto;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) scale(0.5);
        transform-origin: center;
        width: 90%;
        max-width: 340px;
    }
    .show-chatbot .chatbot-wrapper {
        transform: translate(-50%, -50%) scale(1);
    }
}
</style>
<?php 
$sek  = date('Y');
$awal = $sek-100;
?>

<script>
  $( ".datepicker" ).datepicker({
    inline: true,
    changeYear: true,
    changeMonth: true,
    dateFormat: "dd-mm-yy",
    yearRange: "<?php echo $awal ?>:<?php $tahundepan = date('Y')+2; echo $tahundepan; ?>"
  });

  $( ".tanggal" ).datepicker({
    inline: true,
    changeYear: true,
    changeMonth: true,
    dateFormat: "dd-mm-yy",
    yearRange: "<?php echo $awal ?>:<?php $tahundepan = date('Y')+2; echo $tahundepan; ?>"
  });

  $( ".tanggalan" ).datepicker({
    inline: true,
    changeYear: true,
    changeMonth: true,
    dateFormat: "dd-mm-yy",
    yearRange: "<?php echo $awal ?>:<?php $tahundepan = date('Y')+2; echo $tahundepan; ?>"
  });

</script>
<a href="https://api.whatsapp.com/send?phone=<?php echo $site_setting->hp ?>" class="whatsapp-link" target="_blank">
        <i class="fab fa-whatsapp"></i>
</a>

<!-- AI Chatbot UI -->
<button class="chatbot-toggler">
    <?php if(!empty($site_setting->icon_chatbot)) { ?>
        <img src="<?php echo base_url('assets/upload/image/'.$site_setting->icon_chatbot) ?>" class="chatbot-icon-img" style="width: 40px; height: 40px; border-radius: 50%; position: absolute; transition: opacity 0.2s ease, transform 0.2s ease;">
    <?php } else { ?>
        <i class="fas fa-robot"></i>
    <?php } ?>
    <i class="fas fa-times"></i>
</button>
<div class="chatbot-wrapper">
    <div class="chatbot-header">
        <h2>Asisten AI Madrasah</h2>
    </div>
    <div class="chatbot-body" id="chatbot-body">
        <div class="chat chat-incoming">
            <p>Halo! Saya Asisten Virtual dari <?php echo $this->website->namaweb() ?>. Ada yang bisa saya bantu terkait madrasah ini?</p>
        </div>
    </div>
    <div class="quick-replies">
        <button class="quick-reply-btn">Berapa biaya pendaftarannya?</button>
        <button class="quick-reply-btn">Bagaimana syarat pendaftarannya?</button>
        <button class="quick-reply-btn">Siapa kepala madrasah ini?</button>
        <button class="quick-reply-btn">Di mana alamatnya?</button>
        <button class="quick-reply-btn">Apa saja visi misinya?</button>
        <button class="quick-reply-btn">Jadwal pendaftaran (Gelombang)?</button>
        <button class="quick-reply-btn">Apa saja prestasi madrasah?</button>
        <button class="quick-reply-btn">Berita terbaru?</button>
    </div>
    <div class="chatbot-footer">
        <div class="chatbot-footer-inner">
            <textarea id="chatbot-input" placeholder="Ketik pesan Anda..." required></textarea>
            <button id="chatbot-send-btn"><i class="fas fa-arrow-up"></i></button>
        </div>
    </div>
</div>
<!-- /AI Chatbot UI -->

<!--==============================
Footer Area
==============================-->
<footer class="bg-navy text-inverse">
    <div class="container py-13 py-md-15">
      <div class="row gy-6 gy-lg-0">
        <div class="col-md-4 col-lg-4">
          <div class="widget">
            <img class="mb-4 img-fluid" src="<?php echo $this->website->logo() ?>" srcset="<?php echo $this->website->logo() ?> 2x" alt="<?php echo $this->website->namaweb() ?>" />
            <p class="mb-4">© <?php echo date('Y') ?> <?php echo $this->website->namaweb() ?>. <br class="d-none d-lg-block" />All rights reserved.</p>
            <nav class="nav social ">
              <a href="<?php echo $site_setting->twitter ?>"><i class="fab fa-twitter"></i></a>
              <a href="<?php echo $site_setting->facebook ?>"><i class="fab fa-facebook-f"></i></a>
              <a href="<?php echo $site_setting->facebook ?>"><i class="fab fa-tiktok"></i></a>
              <a href="<?php echo $site_setting->instagram ?>"><i class="fab fa-instagram"></i></a>
              <a href="<?php echo $site_setting->youtube ?>"><i class="fab fa-youtube"></i></a>
            </nav>
            <!-- /.social -->
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <div class="col-md-4 col-lg-4">
          <div class="widget">
            <h4 class="widget-title  mb-3 text-white">Hubungi Kami</h4>
            <address class="pe-xl-15 pe-xxl-17"><?php echo $site_setting->alamat ?></address>
            <a href="mailto:<?php echo $site_setting->email ?>" class="link-body" ><i class="fa fa-envelope"></i> <?php echo $site_setting->email ?></a>
            <br /><a href="https://api.whatsapp.com/send?phone=<?php echo $site_setting->hp ?>" class="link-body" target="_blank"> <i class="fab fa-whatsapp" ></i> <?php echo $site_setting->telepon ?> </a>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <div class="col-md-4 col-lg-4">
          <div class="widget">
            <h4 class="widget-title  mb-3 text-white">Tentang Kami</h4>
            <ul class="list-unstyled text-reset mb-0">
              <!-- <li><a href="<?php echo base_url('profil') ?>">Profil Kami</a></li> -->
              <li><a href="<?php echo base_url('berita') ?>">Berita dan Artikel</a></li>
              <?php if($site_setting->menu_prestasi=='Publish') { ?>
              <li><a href="<?php echo base_url('prestasi') ?>">Prestasi &amp; Penghargaan</a></li>
              <?php } if($site_setting->menu_unduhan=='Publish') { ?>
              <li><a href="<?php echo base_url('download') ?>">Download File</a></li>
              <?php } if($site_setting->menu_galeri=='Publish') { ?>
              <li><a href="<?php echo base_url('galeri') ?>">Galeri Gambar</a></li>
              <li><a href="<?php echo base_url('video') ?>">Galeri Video</a></li>
              <?php } ?>
              <li><a href="<?php echo base_url('kontak') ?>">Kontak Kami</a></li>
            </ul>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        
      </div>
      <!--/.row -->
    </div>
    <!-- /.container -->
  </footer>
  <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>
  <script src="<?php echo base_url() ?>assets/template/assets/js/plugins.js"></script>
  <script src="<?php echo base_url() ?>assets/template/assets/js/theme.js"></script>
  <script>
$(document).ready(function(){
    $('input.jam').timepicker({
        timeFormat: 'HH:mm:ss',
        // year, month, day and seconds are not important
        minTime: new Date(0, 0, 0, 8, 0, 0),
        maxTime: new Date(0, 0, 0, 15, 0, 0),
        // time entries start being generated at 6AM but the plugin 
        // shows only those within the [minTime, maxTime] interval
        startHour: 6,
        // the value of the first item in the dropdown, when the input
        // field is empty. This overrides the startHour and startMinute 
        // options
        startTime: new Date(0, 0, 0, 8, 20, 0),
        // items in the dropdown are separated by at interval minutes
        interval: 10
    });
});

  // Popup Delete
  $(document).on("click", ".delete-link", function(e){
    e.preventDefault();
    var url = $(this).attr("href");
    Swal.fire({
        title: 'Anda yakin?',
        text: "Jika dihapus, data tidak dapat dikembalikan lagi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus Data!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
  });

  // Popup Update/Disable
  $(document).on("click", ".disable-link", function(e){
    e.preventDefault();
    var url = $(this).attr("href");
    Swal.fire({
      title: "Yakin akan mengupdate data ini?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: "Ya, Update!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  });


  <?php if(isset($_GET['logout'])) { ?>
    Swal.fire({
      icon: 'success',
      heightAuto: false,
      timer: 3000,
      title: 'Sukses...',
      text: 'Anda berhasil logout.',
    })
  <?php } ?>
  <?php 
  $sessionWarning = Session()->getFlashdata('warning');
  if($sessionWarning) { 
  ?>
  // Notifikasi
  Swal.fire({
    icon: 'warning',
    title: 'Oops...',
    timer: 3000,
    heightAuto: false,
    text: '<?php echo $sessionWarning; ?>',
  })
  <?php } ?>
  <?php 
  $sessionSukses = Session()->getFlashdata('sukses');
  if($sessionSukses) { 
  ?>
  // Notifikasi
  Swal.fire({
    icon: 'success',
    heightAuto: false,
    timer: 3000,
    title: 'Alhamdulillah...',
    text: '<?php echo $sessionSukses; ?>',
  })
  <?php } ?>
  </script>

  <!-- OneSignal Web Push Integration -->
  <?php
  $oneSignalAppId = getenv('ONESIGNAL_APP_ID');
  $externalUserId = '';
  if (Session()->get('username')) {
      $externalUserId = 'admin_' . Session()->get('id_user');
  } elseif (Session()->get('username_siswa')) {
      $externalUserId = 'siswa_' . Session()->get('id_akun');
  }
  ?>
  <?php if(!empty($oneSignalAppId)) { ?>
  <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
  <script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function(OneSignal) {
      await OneSignal.init({
        appId: "<?php echo $oneSignalAppId ?>",
        serviceWorkerPath: "<?php echo parse_url(base_url('OneSignalSDKWorker.js'), PHP_URL_PATH) ?>",
        serviceWorkerParam: {
          scope: "<?php echo parse_url(base_url(), PHP_URL_PATH) ?>"
        },
        notifyButton: {
          enable: false, // Disabling default bell to avoid UI clutter
        },
        welcomeNotification: {
          disable: true
        },
      });
      <?php if(!empty($externalUserId)) { ?>
        await OneSignal.login("<?php echo $externalUserId ?>");
        
        // Auto-request permission on user login if not already granted
        if (!OneSignal.Notifications.permission) {
          try {
            await OneSignal.Notifications.requestPermission();
          } catch (e) {
            console.warn("OneSignal Permission Request Error:", e);
          }
        }
      <?php } ?>
    });
  </script>
  <?php } ?>

  <script>
  // Chatbot Logic
  $(document).ready(function() {
      const chatbotToggler = document.querySelector(".chatbot-toggler");
      const chatbotBody = document.querySelector("#chatbot-body");
      const chatInput = document.querySelector("#chatbot-input");
      const sendChatBtn = document.querySelector("#chatbot-send-btn");

      chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));

      const createChatLi = (message, className) => {
          const chatLi = document.createElement("div");
          chatLi.classList.add("chat", className);
          let chatContent = className === "chat-outgoing" ? `<p></p>` : `<p></p>`;
          chatLi.innerHTML = chatContent;
          chatLi.querySelector("p").innerHTML = message;
          return chatLi;
      }

      const generateResponse = (incomingChatLi, userMessage) => {
          const messageElement = incomingChatLi.querySelector("p");
          
          $.ajax({
              url: '<?php echo base_url('chatbot/send') ?>',
              type: 'POST',
              dataType: 'json',
              data: {
                  message: userMessage
              },
              success: function(res) {
                  if(res.status === 'success') {
                      let text = res.reply;
                      // Simple markdown parser
                      text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                      text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
                      text = text.replace(/\n/g, '<br>');
                      messageElement.innerHTML = text;
                  } else {
                      messageElement.innerHTML = "Maaf, terjadi kesalahan: " + res.message;
                      messageElement.style.color = "#d9534f";
                  }
                  chatbotBody.scrollTo(0, chatbotBody.scrollHeight);
              },
              error: function() {
                  messageElement.innerHTML = "Maaf, gagal terhubung ke server. Silakan coba lagi.";
                  messageElement.style.color = "#d9534f";
                  chatbotBody.scrollTo(0, chatbotBody.scrollHeight);
              }
          });
      }

      const handleChat = () => {
          const userMessage = chatInput.value.trim();
          if(!userMessage) return;

          chatInput.value = "";
          chatInput.style.height = "20px";

          // Append user's message
          chatbotBody.appendChild(createChatLi(userMessage, "chat-outgoing"));
          chatbotBody.scrollTo(0, chatbotBody.scrollHeight);

          setTimeout(() => {
              // Show thinking indicator
              const incomingChatLi = createChatLi("Mengetik...", "chat-incoming");
              chatbotBody.appendChild(incomingChatLi);
              chatbotBody.scrollTo(0, chatbotBody.scrollHeight);
              generateResponse(incomingChatLi, userMessage);
          }, 600);
      }

      // Auto-resize textarea as user types
      chatInput.addEventListener("input", () => {
          chatInput.style.height = "20px";
          chatInput.style.height = `${Math.min(chatInput.scrollHeight, 80)}px`;
      });

      chatInput.addEventListener("keydown", (e) => {
          if(e.key === "Enter" && !e.shiftKey) {
              e.preventDefault();
              handleChat();
          }
      });

      sendChatBtn.addEventListener("click", handleChat);

      // Quick Reply click event
      document.querySelectorAll(".quick-reply-btn").forEach(btn => {
          btn.addEventListener("click", () => {
              chatInput.value = btn.innerText;
              handleChat();
              btn.blur(); // Menghilangkan fokus visual (warna hijau) setelah diklik
          });
      });
  });
  </script>
  <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
// adada
  $(function () {
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })

    //Handle starring for font awesome
    $('.mailbox-star').click(function (e) {
      e.preventDefault()
      //detect type
      var $this = $(this).find('a > i')
      var fa    = $this.hasClass('fa')

      //Switch states
      if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
      }
    })
  })

  
</script>

</body>
</html>