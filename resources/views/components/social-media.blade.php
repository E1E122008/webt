@props([
    'showTitle' => true,
    'title' => 'Ikuti Kami',
    'subtitle' => 'Ikuti media sosial kami untuk informasi terbaru',
    'class' => '',
    'size' => 'normal' // normal, small, large
])

@php
    $socialMedia = \App\Helpers\SettingsHelper::get('social_media', []);
    $villageName = \App\Helpers\SettingsHelper::get('village_name', 'Desa Tetembomua');
    $contactPhone = \App\Helpers\SettingsHelper::get('contact_phone', '+62 812-3456-7890');
    
    // Size classes
    $iconSize = match($size) {
        'small' => 'fa-2x',
        'large' => 'fa-4x',
        default => 'fa-3x'
    };
    
    $cardClass = match($size) {
        'small' => 'col-md-2 col-4 mb-3',
        'large' => 'col-md-3 col-6 mb-4',
        default => 'col-md-3 col-6 mb-4'
    };
@endphp

<div class="social-media-section {{ $class }}">
    @if($showTitle)
        <div class="section-title text-center mb-4">
            <h2>{{ $title }}</h2>
            <p class="text-muted">{{ $subtitle }}</p>
        </div>
    @endif
    
    <div class="row justify-content-center text-center">
        @if(!empty($socialMedia['facebook']) && $socialMedia['facebook'] !== '#' && $socialMedia['facebook'] !== '')
            <!-- Facebook -->
            <div class="{{ $cardClass }}">
                <a href="{{ $socialMedia['facebook'] }}" 
                   class="text-decoration-none social-link" 
                   target="_blank" 
                   rel="noopener"
                   title="Follow us on Facebook">
                    <div class="card h-100 social-card">
                        <div class="card-body">
                            <i class="fab fa-facebook {{ $iconSize }} text-primary mb-3"></i>
                            <h6>Facebook</h6>
                            @if(!empty($socialMedia['facebook_handle']))
                                <small class="text-muted">{{ $socialMedia['facebook_handle'] }}</small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endif
        
        @if(!empty($socialMedia['instagram']) && $socialMedia['instagram'] !== '#' && $socialMedia['instagram'] !== '')
            <!-- Instagram -->
            <div class="{{ $cardClass }}">
                <a href="{{ $socialMedia['instagram'] }}" 
                   class="text-decoration-none social-link" 
                   target="_blank" 
                   rel="noopener"
                   title="Follow us on Instagram">
                    <div class="card h-100 social-card">
                        <div class="card-body">
                            <i class="fab fa-instagram {{ $iconSize }} text-danger mb-3"></i>
                            <h6>Instagram</h6>
                            @if(!empty($socialMedia['instagram_handle']))
                                <small class="text-muted">{{ $socialMedia['instagram_handle'] }}</small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endif
        
        @if(!empty($socialMedia['youtube']) && $socialMedia['youtube'] !== '#' && $socialMedia['youtube'] !== '')
            <!-- YouTube -->
            <div class="{{ $cardClass }}">
                <a href="{{ $socialMedia['youtube'] }}" 
                   class="text-decoration-none social-link" 
                   target="_blank" 
                   rel="noopener"
                   title="Subscribe to our YouTube channel">
                    <div class="card h-100 social-card">
                        <div class="card-body">
                            <i class="fab fa-youtube {{ $iconSize }} text-danger mb-3"></i>
                            <h6>YouTube</h6>
                            @if(!empty($socialMedia['youtube_handle']))
                                <small class="text-muted">{{ $socialMedia['youtube_handle'] }}</small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endif
        
        @if(!empty($socialMedia['whatsapp']) && $socialMedia['whatsapp'] !== '#' && $socialMedia['whatsapp'] !== '')
            <!-- WhatsApp -->
            <div class="{{ $cardClass }}">
                <a href="{{ $socialMedia['whatsapp'] }}" 
                   class="text-decoration-none social-link" 
                   target="_blank" 
                   rel="noopener"
                   title="Contact us on WhatsApp">
                    <div class="card h-100 social-card">
                        <div class="card-body">
                            <i class="fab fa-whatsapp {{ $iconSize }} text-success mb-3"></i>
                            <h6>WhatsApp</h6>
                            @if(!empty($socialMedia['whatsapp_number']))
                                <small class="text-muted">{{ $socialMedia['whatsapp_number'] }}</small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endif
        
        @if(!empty($socialMedia['tiktok']) && $socialMedia['tiktok'] !== '#' && $socialMedia['tiktok'] !== '')
            <!-- TikTok -->
            <div class="{{ $cardClass }}">
                <a href="{{ $socialMedia['tiktok'] }}" 
                   class="text-decoration-none social-link" 
                   target="_blank" 
                   rel="noopener"
                   title="Follow us on TikTok">
                    <div class="card h-100 social-card">
                        <div class="card-body">
                            <i class="fab fa-tiktok {{ $iconSize }} text-dark mb-3"></i>
                            <h6>TikTok</h6>
                            @if(!empty($socialMedia['tiktok_handle']))
                                <small class="text-muted">{{ $socialMedia['tiktok_handle'] }}</small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endif
        
        @if(empty($socialMedia['facebook']) && empty($socialMedia['instagram']) && empty($socialMedia['youtube']) && empty($socialMedia['whatsapp']) && empty($socialMedia['tiktok']))
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Media sosial belum dikonfigurasi. Silakan hubungi administrator untuk mengatur media sosial.
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.social-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.social-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: var(--primary-green, #2E8B57);
}

.social-link:hover {
    text-decoration: none !important;
}

.social-link:hover .social-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.social-card .card-body {
    padding: 1.5rem;
}

.social-card h6 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.social-card small {
    font-size: 0.85rem;
    color: #6c757d;
}

/* TikTok specific styling */
.social-card .fa-tiktok {
    background: linear-gradient(45deg, #ff0050, #00f2ea);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .social-card .card-body {
        padding: 1rem;
    }
    
    .social-card h6 {
        font-size: 0.9rem;
    }
    
    .social-card small {
        font-size: 0.8rem;
    }
}
</style>
