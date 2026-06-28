<?php 
if($popup) {
 ?>

  <div class="modal fade modal-custom-popup" id="modal-02" tabindex="-1">
       <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content modal-lg">
           <div class="modal-body position-relative">
             <!-- Premium Styled Close Button -->
             <button class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="background-color: rgba(255, 255, 255, 0.85); border-radius: 50%; padding: 0.6rem; box-shadow: 0 2px 10px rgba(0,0,0,0.15); z-index: 1051;"></button>
             
             <div class="row align-items-center">
               <div class="col-md-6 text-center">
                 <figure class="mb-md-0 mb-3">
                     <a href="<?php echo $popup->website ?>" target="_blank">
                         <img src="<?php echo base_url('assets/upload/image/'.$popup->gambar) ?>" srcset="<?php echo base_url('assets/upload/image/'.$popup->gambar) ?> 2x" alt="<?php echo $popup->judul_galeri ?>" class="img-fluid rounded shadow-sm" style="max-height: 380px; object-fit: cover;" />
                     </a>
                 </figure>
               </div>
               <!-- /column -->
               <div class="col-md-6">
                   <h3 class="mb-2"><a href="<?php echo $popup->website ?>" target="_blank" class="link-dark text-decoration-none"><?php echo $popup->judul_galeri ?></a></h3>
                   <hr class="mt-0 mb-2 p-0">
                    <div class="mb-4 text-secondary">
                        <?php echo $popup->isi ?>
                    </div>

                    <div id="mc_embed_signup">
                     <a href="<?php echo $popup->website ?>" class="btn btn-primary rounded-pill px-4" target="_blank">
                         Lihat detail &nbsp;<i class="fa fa-chevron-right fs-14"></i>
                     </a>
                   </div>
               </div>
             </div>
             <!-- /.row -->
           </div>
           <!--/.modal-body -->
         </div>
         <!--/.modal-content -->
       </div>
       <!--/.modal-dialog -->
     </div>
     <!--/.modal -->

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var popupModalEl = document.getElementById('modal-02');
        if (popupModalEl != null) {
            // Check if this popup has already been shown in the current browser session
            if (!sessionStorage.getItem('popup_shown_this_session')) {
                // Show with a premium delay of 2.5 seconds
                setTimeout(function() {
                    var myModal = new bootstrap.Modal(popupModalEl);
                    myModal.show();
                    // Mark as shown so it doesn't reappear on page navigation
                    sessionStorage.setItem('popup_shown_this_session', 'true');
                }, 2500);
            }
        }
    });
    </script>
    <?php } ?>