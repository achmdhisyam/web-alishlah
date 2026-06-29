</div>
</div>
              <!-- /.card-body -->
              <div class="card-footer">
                Page rendered: {elapsed_time} | Versi Framework: <?= CodeIgniter\CodeIgniter::CI_VERSION ?>
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y') ?> <?php echo $this->website->namaweb() ?> </strong> 
    All rights reserved  | Versi Framework: <?= CodeIgniter\CodeIgniter::CI_VERSION ?>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php 
$sek  = date('Y');
$awal = $sek-100;
?>

<script>
  tinymce.init({
    selector: '.nilai',
    height: 150,
    menubar: false,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
  });
// ISI
  tinymce.init({
    selector: '#isi, #isi2',
    relative_urls : false,
    remove_script_host : false,
    convert_urls : true,
    height: 500,
    plugins: 'print preview paste searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample code table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools colorpicker textpattern help',
    toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | blocks fontfamily fontsize | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | image | table | removeformat',
    visual_table_class: 'tiny-table'
  });
// KONTEN
  tinymce.init({
    selector: '.konten-berita',
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    toolbar_mode: 'scrolling',
    height: 400,
    plugins: 'print preview paste searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample code table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools colorpicker textpattern help',
    toolbar: [
        'blocks fontfamily fontsize bold italic strikethrough forecolor backcolor copy | code fullscreen preview | save print | pagebreak anchor codesample',
        'undo redo | alignleft aligncenter alignright alignjustify | link image media table | numlist bullist outdent indent | charmap emoticons removeformat | ltr rtl'
    ],
    visual_table_class: 'tiny-table',

    

    // Integrasi Bootstrap
    content_style: `
        @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
        body { font-family: 'Arial', sans-serif; font-size: 16px; padding: 20px;}
        img { max-width: 100%; height: auto; display: block; margin: 10px auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dee2e6; padding: 8px; text-align: left; }
    `,

    // Menyesuaikan gambar agar tidak melebihi lebar textarea
    setup: function (editor) {
        editor.on('init', function () {
            editor.getBody().style.maxWidth = "100%"; 
        });
    }
});


  // ckeditor
  tinymce.init({
    selector: '.ckeditor',
    relative_urls : false,
    remove_script_host : false,
    convert_urls : true,
    height: 300,
    plugins: 'print preview paste searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample code table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools colorpicker textpattern help',
    toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | image | table | removeformat',
    visual_table_class: 'tiny-table'
  });

</script>
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

<!-- teks editor -->
 

<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- pace-progress -->
<script src="<?php echo base_url() ?>assets/admin/plugins/pace-progress/pace.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url() ?>assets/admin/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url() ?>assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/admin/dist/js/adminlte.min.js"></script>
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

  // Global confirmation function for inline onclick="confirmation(event)"
  function confirmation(e) {
    e.preventDefault();
    var url = e.currentTarget.getAttribute('href');
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
  }

  // Handle form submit for bulk delete buttons globally
  $(document).on("click", "button[type='submit'][value='Delete'], button[type='submit'][title*='Hapus'], input[type='submit'][value='Delete']", function(e){
    var btn = $(this);
    var form = btn.closest("form");
    
    // Check if there are any checked items in the form
    var checked = form.find('.mailbox-messages input[type="checkbox"]:checked').length;
    if (checked === 0) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Silakan centang item yang ingin dihapus terlebih dahulu.',
        confirmButtonColor: '#3085d6'
      });
      return false;
    }

    e.preventDefault();
    Swal.fire({
        title: 'Anda yakin?',
        text: "Seluruh data terpilih akan dihapus permanen dari sistem!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // To submit the form with the specific button value, we append a hidden input with the button name and value
          $('<input>').attr({
              type: 'hidden',
              name: btn.attr('name'),
              value: btn.attr('value')
          }).appendTo(form);
          form.submit();
        }
      });
  });

  // Dynamic status select button styling for aksi-massal-select
  $(document).on("change", "#aksi-massal-select", function() {
    var val = $(this).val();
    var btn = $("#proses-aksi-massal-btn");
    if (val === "delete") {
      btn.removeClass("btn-secondary btn-info btn-warning btn-success btn-light btn-dark")
         .addClass("btn-danger");
    } else {
      btn.removeClass("btn-danger btn-secondary btn-info btn-warning btn-success btn-light btn-dark")
         .addClass("btn-secondary");
    }
  });

 // Popup Delete
$(document).on("click", ".disable-link", function(e){
  e.preventDefault();
  url = $(this).attr("href");
  Swal.fire({
    title:"Yakin akan mengupdate data ini?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: 'btn btn-danger',
    cancelButtonClass: 'btn btn-success',
    buttonsStyling: false,
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(isConfirm){
    if(isConfirm){
      $.ajax({
        url: url,
        success: function(resp){
          window.location.href = url;
        }
      });
    }
    return false;
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
<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    var stepperEl = document.querySelector('.bs-stepper');
    if (stepperEl) {
      window.stepper = new Stepper(stepperEl);
    }
  })

  
</script>
<script>
    $(function () {
    var exportConfig = [
        { extend: 'copy', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'csv', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'excel', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'pdf', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'print', exportOptions: { columns: ':not(:last-child)' } },
        "colvis"
      ];
      
    var exportConfig2 = [
        { extend: 'copy', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'csv', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'excel', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'pdf', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'print', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        "colvis"
      ];

    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": exportConfig
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": exportConfig2
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": exportConfig
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
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

</body>
</html>
