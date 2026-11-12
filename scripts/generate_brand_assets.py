#!/usr/bin/env python3
"""
Generate complete set of brand assets for PickMeRoute:
- favicon.svg
- favicon.ico (16x16, 32x32, 48x48)
- favicon-16x16.png
- favicon-32x32.png
- favicon-48x48.png
- apple-touch-icon.png (180x180)
- android-chrome-192x192.png (192x192)
- android-chrome-512x512.png (512x512)
- site.webmanifest
- public/images/og-image.jpg (1200x630)
"""

import os
import json
from PIL import Image, ImageDraw, ImageFont, ImageFilter

def bezier_point(p0, p1, p2, p3, t):
    return (
        (1-t)**3 * p0[0] + 3*(1-t)**2 * t * p1[0] + 3*(1-t) * t**2 * p2[0] + t**3 * p3[0],
        (1-t)**3 * p0[1] + 3*(1-t)**2 * t * p1[1] + 3*(1-t) * t**2 * p2[1] + t**3 * p3[1]
    )

def generate_base_icon(size=512):
    img = Image.new('RGBA', (size, size), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Dark squircle
    corner_radius = int(size * 0.22)
    border_inset = int(size * 0.03)
    border_width = max(2, int(size * 0.016))
    
    # Outer squircle background
    draw.rounded_rectangle(
        [border_inset, border_inset, size - border_inset, size - border_inset],
        radius=corner_radius,
        fill=(11, 15, 23, 255),
        outline=(34, 197, 94, 230),
        width=border_width
    )

    # Subtle inner glow line
    inner_inset = border_inset + int(size * 0.02)
    draw.rounded_rectangle(
        [inner_inset, inner_inset, size - inner_inset, size - inner_inset],
        radius=corner_radius - 8,
        outline=(34, 197, 94, 60),
        width=max(1, int(size * 0.006))
    )

    # Scale and center the automotive speed swoosh
    scale = size * 0.0180
    ox = (size - 45 * scale) / 2
    oy = (size - 28 * scale) / 2 - (size * 0.015)

    # 1. Upper body swoosh
    poly1 = [(2, 24)]
    for i in range(1, 20):
        t = i / 20.0
        poly1.append(bezier_point((2, 24), (8, 24), (13, 22), (17, 15), t))
    for i in range(1, 20):
        t = i / 20.0
        poly1.append(bezier_point((17, 15), (21, 8), (26, 4), (36, 4), t))
    for i in range(1, 20):
        t = i / 20.0
        poly1.append(bezier_point((36, 4), (41, 4), (44, 5.5), (45, 6.5), t))
    for i in range(1, 20):
        t = i / 20.0
        poly1.append(bezier_point((45, 6.5), (41, 8.5), (35, 9.5), (30, 11), t))
    for i in range(1, 20):
        t = i / 20.0
        poly1.append(bezier_point((30, 11), (23, 13), (19, 20), (14, 26), t))
    for i in range(1, 20):
        t = i / 20.0
        poly1.append(bezier_point((14, 26), (10, 30), (5, 31), (0, 31), t))
    poly1.append((2, 24))

    pts1 = [(ox + p[0] * scale, oy + p[1] * scale) for p in poly1]
    draw.polygon(pts1, fill=(34, 197, 94, 255))

    # 2. Lower accent swoosh
    poly2 = [(12, 26.5)]
    for i in range(1, 20):
        t = i / 20.0
        poly2.append(bezier_point((12, 26.5), (18, 26.5), (24, 24), (33, 19), t))
    for i in range(1, 20):
        t = i / 20.0
        poly2.append(bezier_point((33, 19), (37, 16.5), (41, 13), (44, 10), t))
    for i in range(1, 20):
        t = i / 20.0
        poly2.append(bezier_point((44, 10), (40, 14), (34, 17), (27, 20), t))
    for i in range(1, 20):
        t = i / 20.0
        poly2.append(bezier_point((27, 20), (20, 23), (15, 24), (10, 24.5), t))
    poly2.append((12, 26.5))

    pts2 = [(ox + p[0] * scale, oy + p[1] * scale) for p in poly2]
    draw.polygon(pts2, fill=(22, 163, 74, 255))

    # 3. Axle line
    w1_x = ox + 11 * scale
    w1_y = oy + 25 * scale
    w2_x = ox + 33 * scale
    w2_y = oy + 25 * scale
    draw.line([(w1_x, w1_y), (w2_x, w2_y)], fill=(34, 197, 94, 255), width=max(2, int(2.2 * scale)))

    # 4. Wheels
    r = 3.0 * scale
    draw.ellipse([w1_x - r, w1_y - r, w1_x + r, w1_y + r], fill=(34, 197, 94, 255), outline=(74, 222, 128, 255), width=max(1, int(scale * 0.38)))
    draw.ellipse([w2_x - r, w2_y - r, w2_x + r, w2_y + r], fill=(34, 197, 94, 255), outline=(74, 222, 128, 255), width=max(1, int(scale * 0.38)))

    # 5. Inner wheel hubs
    r_inner = r * 0.45
    draw.ellipse([w1_x - r_inner, w1_y - r_inner, w1_x + r_inner, w1_y + r_inner], fill=(11, 15, 23, 255))
    draw.ellipse([w2_x - r_inner, w2_y - r_inner, w2_x + r_inner, w2_y + r_inner], fill=(11, 15, 23, 255))

    return img

def generate_svg_favicon(output_path):
    svg_content = """<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
    <defs>
        <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#0F172A"/>
            <stop offset="100%" stop-color="#020617"/>
        </linearGradient>
        <linearGradient id="swooshGrad" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="#22C55E"/>
            <stop offset="100%" stop-color="#4ADE80"/>
        </linearGradient>
    </defs>
    <rect width="512" height="512" rx="112" fill="url(#bgGrad)"/>
    <rect width="488" height="488" x="12" y="12" rx="100" fill="none" stroke="#22C55E" stroke-width="8" stroke-opacity="0.9"/>
    <g transform="translate(54, 128) scale(8.8)">
        <path d="M2 24C8 24 13 22 17 15C21 8 26 4 36 4C41 4 44 5.5 45 6.5C41 8.5 35 9.5 30 11C23 13 19 20 14 26C10 30 5 31 0 31L2 24Z" fill="url(#swooshGrad)"/>
        <path d="M12 26.5C18 26.5 24 24 33 19C37 16.5 41 13 44 10C40 14 34 17 27 20C20 23 15 24 10 24.5L12 26.5Z" fill="#16A34A"/>
        <path d="M11 25H33" stroke="#22C55E" stroke-width="2.2" stroke-linecap="round"/>
        <circle cx="11" cy="25" r="3.0" fill="#22C55E" stroke="#4ADE80" stroke-width="0.8"/>
        <circle cx="33" cy="25" r="3.0" fill="#22C55E" stroke="#4ADE80" stroke-width="0.8"/>
        <circle cx="11" cy="25" r="1.3" fill="#0B0F17"/>
        <circle cx="33" cy="25" r="1.3" fill="#0B0F17"/>
    </g>
</svg>"""
    with open(output_path, 'w', encoding='utf-8') as f:
        f.write(svg_content.strip() + '\n')
    print(f"Generated {output_path}")

def generate_webmanifest(output_path):
    manifest = {
        "name": "PickMeRoute — Montreal ↔ Toronto Shuttle",
        "short_name": "PickMeRoute",
        "description": "Daily scheduled intercity passenger minivan shuttle between Montreal (Namur Metro) and Toronto (Yorkdale & Yonge). Fixed schedule, reserved seating, cash payment upon boarding.",
        "start_url": "/",
        "display": "standalone",
        "background_color": "#0B0F17",
        "theme_color": "#111827",
        "icons": [
            {
                "src": "/favicon-16x16.png",
                "sizes": "16x16",
                "type": "image/png"
            },
            {
                "src": "/favicon-32x32.png",
                "sizes": "32x32",
                "type": "image/png"
            },
            {
                "src": "/favicon-48x48.png",
                "sizes": "48x48",
                "type": "image/png"
            },
            {
                "src": "/apple-touch-icon.png",
                "sizes": "180x180",
                "type": "image/png"
            },
            {
                "src": "/android-chrome-192x192.png",
                "sizes": "192x192",
                "type": "image/png"
            },
            {
                "src": "/android-chrome-512x512.png",
                "sizes": "512x512",
                "type": "image/png"
            }
        ]
    }
    with open(output_path, 'w', encoding='utf-8') as f:
        json.dump(manifest, f, indent=4)
    print(f"Generated {output_path}")

def generate_og_image(output_path):
    # 1200x630 Social Share Card
    W, H = 1200, 630
    
    # Load background photo if available, or create luxurious dark gradient
    bg_photo_path = 'public/images/service-intercity.jpg'
    if os.path.exists(bg_photo_path):
        bg = Image.open(bg_photo_path).convert('RGBA')
        # Center crop to 1200x630
        bw, bh = bg.size
        target_ratio = W / H
        current_ratio = bw / bh
        if current_ratio > target_ratio:
            new_bw = int(bh * target_ratio)
            left = (bw - new_bw) // 2
            bg = bg.crop((left, 0, left + new_bw, bh)).resize((W, H), Image.Resampling.LANCZOS)
        else:
            new_bh = int(bw / target_ratio)
            top = (bh - new_bh) // 2
            bg = bg.crop((0, top, bw, top + new_bh)).resize((W, H), Image.Resampling.LANCZOS)
    else:
        bg = Image.new('RGBA', (W, H), (11, 15, 23, 255))

    # Dark cinematic gradient overlays
    overlay = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    ov_draw = ImageDraw.Draw(overlay)
    
    # Left-to-right gradient for text legibility
    for x in range(W):
        alpha = int(245 - (x / W) * 110) # 245 on left to 135 on right
        ov_draw.line([(x, 0), (x, H)], fill=(11, 15, 23, alpha))
        
    card = Image.alpha_composite(bg, overlay)
    draw = ImageDraw.Draw(card)

    # Draw Brand Green accent line at top
    draw.rectangle([0, 0, W, 8], fill=(34, 197, 94, 255))

    # Add the brand icon in top-left
    icon_512 = generate_base_icon(140)
    card.paste(icon_512, (70, 50), icon_512)

    # Fonts
    font_bold = '/System/Library/Fonts/Supplemental/Arial Bold.ttf'
    font_title = ImageFont.truetype(font_bold, 64)
    font_h2 = ImageFont.truetype(font_bold, 36)
    font_body = ImageFont.truetype(font_bold, 24)
    font_badge = ImageFont.truetype(font_bold, 20)
    font_brand = ImageFont.truetype(font_bold, 54)

    # Brand Title beside icon
    draw.text((230, 65), "Pick", fill=(255, 255, 255, 255), font=font_brand)
    draw.text((345, 65), "Me", fill=(34, 197, 94, 255), font=font_brand)
    draw.text((232, 125), "R O U T E", fill=(34, 197, 94, 230), font=font_badge)

    # Badge Pill: "DAILY SCHEDULED SHUTTLE"
    badge_x, badge_y = 70, 230
    draw.rounded_rectangle([badge_x, badge_y, badge_x + 360, badge_y + 38], radius=19, fill=(34, 197, 94, 45), outline=(34, 197, 94, 180), width=2)
    draw.text((badge_x + 18, badge_y + 8), "DAILY PASSENGER SHUTTLE", fill=(34, 197, 94, 255), font=font_badge)

    # Big Headline: Montreal ↔ Toronto
    draw.text((70, 285), "Montreal ↔ Toronto", fill=(255, 255, 255, 255), font=font_title)

    # Subtitle: Service details
    draw.text((70, 375), "Reserved Minivan Seating · Cash on Boarding ($65 CAD)", fill=(226, 232, 240, 255), font=font_h2)

    # Station Details Box
    box_y = 445
    draw.rounded_rectangle([70, box_y, 1130, box_y + 115], radius=24, fill=(17, 24, 39, 210), outline=(255, 255, 255, 40), width=1)
    
    # Hub 1
    draw.text((100, box_y + 24), "1. Station Métro Namur", fill=(255, 255, 255, 255), font=font_body)
    draw.text((100, box_y + 60), "Montreal · 6:30 AM Departure", fill=(148, 163, 184, 255), font=font_badge)

    # Arrow
    draw.text((540, box_y + 38), "⇄", fill=(34, 197, 94, 255), font=font_h2)

    # Hub 2 & 3
    draw.text((630, box_y + 24), "2. Yorkdale & 3. Yonge Station", fill=(255, 255, 255, 255), font=font_body)
    draw.text((630, box_y + 60), "Toronto · 12:15 PM & 1:15 PM Departures", fill=(148, 163, 184, 255), font=font_badge)

    # Bottom Footer line: Website URL & Phone
    draw.text((70, 582), "pickmeroute.com", fill=(34, 197, 94, 255), font=font_body)
    draw.text((950, 582), "Tel: 647-655-1884", fill=(226, 232, 240, 255), font=font_body)

    # Convert to RGB and save as high-quality JPEG
    card.convert('RGB').save(output_path, 'JPEG', quality=92, optimize=True)
    print(f"Generated {output_path}")

def main():
    os.makedirs('public', exist_ok=True)
    os.makedirs('public/images', exist_ok=True)

    print("🎨 Generating PickMeRoute Favicon & Brand Identity Suite...")

    # 1. Base 512x512
    icon_512 = generate_base_icon(512)
    icon_512.save('public/android-chrome-512x512.png', 'PNG')
    print("Generated public/android-chrome-512x512.png")

    # 2. 192x192
    icon_192 = icon_512.resize((192, 192), Image.Resampling.LANCZOS)
    icon_192.save('public/android-chrome-192x192.png', 'PNG')
    print("Generated public/android-chrome-192x192.png")

    # 3. 180x180 (Apple Touch Icon)
    icon_180 = icon_512.resize((180, 180), Image.Resampling.LANCZOS)
    icon_180.save('public/apple-touch-icon.png', 'PNG')
    print("Generated public/apple-touch-icon.png")

    # 4. 48x48
    icon_48 = icon_512.resize((48, 48), Image.Resampling.LANCZOS)
    icon_48.save('public/favicon-48x48.png', 'PNG')
    print("Generated public/favicon-48x48.png")

    # 5. 32x32
    icon_32 = icon_512.resize((32, 32), Image.Resampling.LANCZOS)
    icon_32.save('public/favicon-32x32.png', 'PNG')
    print("Generated public/favicon-32x32.png")

    # 6. 16x16
    icon_16 = icon_512.resize((16, 16), Image.Resampling.LANCZOS)
    icon_16.save('public/favicon-16x16.png', 'PNG')
    print("Generated public/favicon-16x16.png")

    # 7. Multi-resolution favicon.ico containing 16x16, 32x32, 48x48
    icon_512.save('public/favicon.ico', format='ICO', sizes=[(16, 16), (32, 32), (48, 48)])
    print("Generated multi-resolution public/favicon.ico")

    # 8. SVG Vector Favicon
    generate_svg_favicon('public/favicon.svg')

    # 9. Web App Manifest
    generate_webmanifest('public/site.webmanifest')

    # 10. Open Graph 1200x630 Social Banner
    generate_og_image('public/images/og-image.jpg')

    print("✅ All Favicon & Social Meta Assets Generated Successfully!")

if __name__ == '__main__':
    main()
