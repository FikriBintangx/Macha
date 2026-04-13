<?php
$file = 'c:\\laragon\\www\\macha\\application\\views\\guest\\home.php';
$content = file_get_contents($file);

// 1. Move internal <style> out of body into <head>
preg_match('/<style>\s*\/\* ─── PREMIUM STORY STYLES ─── \*\/(.*?)<\/style>/s', $content, $matches);
if (!empty($matches)) {
    $styles_to_move = "    /* ─── PREMIUM STORY STYLES ─── */" . $matches[1];
    
    // Remove it from the body
    $content = preg_replace('/<style>\s*\/\* ─── PREMIUM STORY STYLES ─── \*\/(.*?)<\/style>\s*/s', '', $content);
    
    // Insert into head style block
    $content = str_replace('/* Force clickable state after animation */', $styles_to_move . "\n\n    /* Force clickable state after animation */", $content);
}

// 2. Wrap the premium map section with scalable structured SVG using strict string replacement
$old_map = <<<HTML
      <div class="premium-map-container">
        <div class="shipping-dashboard"></div>
        
        <div class="node-wrap">
          <!-- Origin -->
          <div class="node" style="top: 72%; left: 26%; width: 14px; height: 14px; background:#fff; z-index:10;">
            <div class="node-pulse" style="background:#fff"></div>
            <div class="location-card" style="top: -20px; left: 50%; opacity:1; display:flex; flex-direction:column; background:white; color:black; padding:10px; border-radius:10px;">
               <span class="loc-title">Pusat MariMatcha</span>
               <span class="loc-desc">Tangerang, Banten</span>
            </div>
          </div>

          <!-- Target Nodes -->
          <div class="node" style="top: 25%; left: 15%;"><div class="node-pulse"></div></div> <!-- Medan -->
          <div class="node" style="top: 60%; left: 45%;"><div class="node-pulse"></div></div> <!-- Surabaya -->
          <div class="node" style="top: 50%; left: 60%;"><div class="node-pulse"></div></div> <!-- Makassar -->
          <div class="node" style="top: 40%; left: 85%;"><div class="node-pulse"></div></div> <!-- Papua -->
        </div>

        <svg style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:4; pointer-events:none;">
           <path class="shipping-line" d="M260,290 Q200,200 150,110" id="l1"></path>
           <path class="shipping-line" d="M260,290 Q350,300 450,270" id="l2"></path>
           <path class="shipping-line" d="M260,290 Q400,200 600,225" id="l3"></path>
           <path class="shipping-line" d="M260,290 Q500,150 850,180" id="l4"></path>
        </svg>

      </div>
HTML;

$new_map = <<<HTML
      <div class="premium-map-container" style="background:#050d08; padding: 40px 20px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.08); position:relative; overflow:hidden;">
        <svg class="id-map-organic-svg" viewBox="0 0 1000 400" preserveAspectRatio="xMidYMid meet" style="width:100%; height:auto; filter:drop-shadow(0 0 30px rgba(139, 170, 124, 0.2));">
           <style>
             .map-island { fill: #0a1f1f; stroke: #8BAA7C; stroke-width: 1; opacity: 0.4; pointer-events:none; }
             .s-line { fill: none; stroke: #8BAA7C; stroke-width: 2.5; stroke-dasharray: 200; stroke-dashoffset: 200; opacity: 0.8; filter: blur(1px); }
           </style>
           <!-- Islands -->
           <path class="map-island" d="M120,80 Q180,120 220,180 Q180,240 100,200 Q80,140 120,80 Z" />
           <path class="map-island" d="M230,280 Q350,320 500,340 Q580,350 450,360 Q300,340 230,280 Z" />
           <path class="map-island" d="M380,80 Q450,50 500,120 Q550,220 450,240 Q350,220 380,80 Z" />
           <path class="map-island" d="M580,100 Q630,80 650,150 Q600,200 560,240 Q520,200 560,150 Z" />
           <path class="map-island" d="M780,150 Q900,160 960,240 Q900,320 820,300 Q760,240 780,150 Z" />
           <circle cx="500" cy="360" r="4" fill="#8BAA7C" />
           <circle cx="530" cy="365" r="5" fill="#8BAA7C" />
           <circle cx="560" cy="368" r="4" fill="#8BAA7C" />
           <circle cx="600" cy="370" r="6" fill="#8BAA7C" />
           <path class="map-island" d="M650,370 Q700,380 750,360 Q700,365 650,370 Z" /> 
           
           <!-- Connection Networks -->
           <path class="s-line shipping-line" d="M260,290 Q180,220 150,150" />
           <path class="s-line shipping-line" d="M260,290 Q350,200 420,160" />
           <path class="s-line shipping-line" d="M260,290 Q400,240 580,180" />
           <path class="s-line shipping-line" d="M260,290 Q500,310 820,240" />

           <!-- Target Nodes -->
           <circle cx="150" cy="150" r="4" fill="#8BAA7C" />
           <circle cx="420" cy="160" r="4" fill="#8BAA7C" />
           <circle cx="580" cy="180" r="4" fill="#8BAA7C" />
           <circle cx="820" cy="240" r="4" fill="#8BAA7C" />

           <!-- Node Tangerang Pulse -->
           <circle cx="260" cy="290" r="10" fill="none" stroke="#8BAA7C" stroke-width="2">
               <animate attributeName="r" values="6; 24; 6" dur="2s" repeatCount="indefinite" />
               <animate attributeName="opacity" values="1; 0; 1" dur="2s" repeatCount="indefinite" />
           </circle>
           <circle cx="260" cy="290" r="6" fill="#fff" />
        </svg>

        <!-- Location Tooltip for Tangerang -->
        <div style="position:absolute; top: 62%; left: 26%; transform:translateX(-50%); background:rgba(255,255,255,0.95); padding:8px 16px; border-radius:12px; text-align:center; box-shadow: 0 10px 20px rgba(0,0,0,0.3); z-index:10; pointer-events:none;">
            <div style="font-weight:900; font-size:0.9rem; color:#102416;">Pusat MariMatcha</div>
            <div style="font-size:0.75rem; color:#53725D;"><i class="fa-solid fa-location-dot me-1"></i> Tangerang, Banten</div>
            <div style="position:absolute; top:-6px; left:50%; width:12px; height:12px; background:rgba(255,255,255,0.95); transform:translateX(-50%) rotate(45deg);"></div>
        </div>
      </div>
HTML;

$content = str_replace($old_map, $new_map, $content);

// 3. Ensure JS map animation is added
if (strpos($content, '// LUX MAP ANIMATION') === false) {
    if (strpos($content, '      // 3D TILT EFFECT REFINED') !== false) {
        $js_anim = <<<JS
      // LUX MAP ANIMATION
      gsap.utils.toArray('.shipping-line').forEach(line => {
        gsap.to(line, {
          strokeDashoffset: 0,
          opacity: 0.8,
          duration: 3,
          repeat: -1,
          ease: "power2.inOut"
        });
      });\n
JS;
        $content = str_replace('      // 3D TILT EFFECT REFINED', $js_anim . '      // 3D TILT EFFECT REFINED', $content);
    }
}

file_put_contents($file, $content);
echo "Layout fixed safely!\n";
?>
