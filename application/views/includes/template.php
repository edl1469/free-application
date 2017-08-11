<?php
    $this->load->view( 'includes/header' );

    if( ENVIRONMENT == "development" OR ENVIRONMENT == "testing") {
        $this->load->view( 'includes/cookies' );
    }

    if( $bodyId != 'authenticate' ) {
        $this->load->view( 'includes/navigation' );
    }

    $this->load->view( $view );

    $this->load->view( 'includes/footer' );

?>