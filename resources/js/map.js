import * as maplibregl from 'maplibre-gl';
import maplibreWorkerUrl from 'maplibre-gl/dist/maplibre-gl-worker.mjs?url';
import 'maplibre-gl/dist/maplibre-gl.css';

maplibregl.setWorkerUrl(maplibreWorkerUrl);

document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('maplibre-container');
    const skeleton = document.getElementById('map-skeleton');
    const errorBox = document.getElementById('map-error-state');

    if (!mapContainer) return;

    let map = null;
    let geojsonData = null;

    const bounds = [
        [108.65, -7.85], // Southwest [lng, lat]
        [109.88, -7.12], // Northeast [lng, lat]
    ];

    function initMap() {
        if (skeleton) skeleton.classList.remove('hidden');
        if (errorBox) errorBox.classList.add('hidden');

        try {
            map = new maplibregl.Map({
                container: 'maplibre-container',
                style: {
                    version: 8,
                    sources: {},
                    layers: [
                        {
                            id: 'background',
                            type: 'background',
                            paint: {
                                'background-color': '#f8fafc',
                            },
                        },
                    ],
                },
                bounds: bounds,
                fitBoundsOptions: { padding: 35, duration: 0 },
                attributionControl: false,
                maxBounds: [
                    [107.5, -8.5],
                    [111.0, -6.5],
                ],
            });

            map.addControl(new maplibregl.NavigationControl({ showCompass: false }), 'top-right');

            window.addEventListener('resize', () => {
                if (map) map.resize();
            });

            map.on('load', async () => {
                try {
                    const response = await fetch('/api/v1/map/choropleth');
                    if (!response.ok) throw new Error('Network response was not ok');
                    geojsonData = await response.json();

                    if (skeleton) skeleton.classList.add('hidden');

                    map.addSource('regions-choropleth', {
                        type: 'geojson',
                        data: geojsonData,
                    });

                    // 1. Polygons Fill Layer
                    map.addLayer({
                        id: 'regions-fill',
                        type: 'fill',
                        source: 'regions-choropleth',
                        paint: {
                            'fill-color': [
                                'match',
                                ['get', 'flag'],
                                'under_coverage', '#f59e0b',
                                'over_coverage', '#6366f1',
                                'normal', '#10b981',
                                '#cbd5e1'
                            ],
                            'fill-opacity': [
                                'case',
                                ['boolean', ['feature-state', 'hover'], false],
                                0.95,
                                0.75
                            ],
                        },
                    });

                    // 2. Polygons Line Border
                    map.addLayer({
                        id: 'regions-line',
                        type: 'line',
                        source: 'regions-choropleth',
                        paint: {
                            'line-color': '#0f172a',
                            'line-width': 1.5,
                        },
                    });

                    // 3. Highlight Border
                    map.addLayer({
                        id: 'regions-highlight',
                        type: 'line',
                        source: 'regions-choropleth',
                        paint: {
                            'line-color': '#0f766e',
                            'line-width': 3.5,
                        },
                        filter: ['==', 'bps_code', ''],
                    });

                    // Fit to bounds smoothly
                    map.fitBounds(bounds, { padding: 35, duration: 600 });

                    // Tooltip Popup
                    const popup = new maplibregl.Popup({
                        closeButton: false,
                        closeOnClick: false,
                        className: 'hw-map-popup',
                        offset: 12,
                    });

                    let hoveredStateId = null;

                    map.on('mousemove', 'regions-fill', (e) => {
                        if (e.features && e.features.length > 0) {
                            map.getCanvas().style.cursor = 'pointer';
                            const f = e.features[0];
                            const p = f.properties;

                            map.setFilter('regions-highlight', ['==', 'bps_code', p.bps_code]);

                            const popupHtml = `
                                <div style="font-family: Inter, system-ui, sans-serif; padding: 6px 8px; font-size: 12px; min-width: 175px;">
                                    <div style="font-weight: 700; color: #0f172a; font-size: 13px; margin-bottom: 4px;">${p.name}</div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="color: #64748b;">Kode BPS:</span>
                                        <span style="font-family: monospace; font-weight: 600;">${p.bps_code}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="color: #64748b;">Kuota Bansos:</span>
                                        <span style="font-family: monospace; font-weight: 600;">${Number(p.quota_recipients || 0).toLocaleString('id-ID')}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                        <span style="color: #64748b;">Estimasi Miskin:</span>
                                        <span style="font-family: monospace; font-weight: 600;">${Number(p.poor_estimate || 0).toLocaleString('id-ID')}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 4px; padding-top: 4px; border-top: 1px solid #e2e8f0;">
                                        <span style="color: #64748b;">Rasio Relatif:</span>
                                        <span style="font-weight: 700; color: #0f766e;">${p.relative_ratio}x</span>
                                    </div>
                                    <div style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #0f172a;">
                                        ${p.flag_label || ''}
                                    </div>
                                </div>
                            `;

                            popup.setLngLat(e.lngLat).setHTML(popupHtml).addTo(map);
                        }
                    });

                    map.on('mouseleave', 'regions-fill', () => {
                        map.getCanvas().style.cursor = '';
                        popup.remove();
                        map.setFilter('regions-highlight', ['==', 'bps_code', '']);
                    });

                    // 4. Click Polygon to Focus Card & Table Row
                    map.on('click', 'regions-fill', (e) => {
                        if (e.features && e.features.length > 0) {
                            const p = e.features[0].properties;
                            highlightDomesticItem(p.bps_code);
                        }
                    });

                } catch (err) {
                    console.error('Error loading choropleth data:', err);
                    if (skeleton) skeleton.classList.add('hidden');
                    if (errorBox) errorBox.classList.remove('hidden');
                }
            });
        } catch (err) {
            console.error('MapLibre init error:', err);
            if (skeleton) skeleton.classList.add('hidden');
            if (errorBox) errorBox.classList.remove('hidden');
        }
    }

    function highlightDomesticItem(bpsCode) {
        // Highlight corresponding card
        const card = document.getElementById(`region-card-${bpsCode}`);
        if (card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            card.classList.add('ring-4', 'ring-teal-600', 'transition-all');
            setTimeout(() => card.classList.remove('ring-4', 'ring-teal-600'), 2500);
        }

        // Highlight table row
        const row = document.getElementById(`region-row-${bpsCode}`);
        if (row) {
            row.classList.add('bg-teal-50');
            setTimeout(() => row.classList.remove('bg-teal-50'), 2500);
        }
    }

    // Two-way interaction: Focus polygon when clicking from card or row
    window.hwFocusRegion = (bpsCode, lng, lat) => {
        if (!map) return;
        map.setFilter('regions-highlight', ['==', 'bps_code', bpsCode]);
        if (lng && lat) {
            map.flyTo({ center: [lng, lat], zoom: 9.5, speed: 1.2 });
        }
    };

    // Filter synchronization across map, cards, and table
    window.hwFilterMap = (flag) => {
        if (!map) return;

        // 1. Filter Map
        if (flag === 'all') {
            map.setFilter('regions-fill', null);
            map.setFilter('regions-line', null);
        } else {
            map.setFilter('regions-fill', ['==', 'flag', flag]);
            map.setFilter('regions-line', ['==', 'flag', flag]);
        }

        // 2. Filter DOM Cards
        document.querySelectorAll('.hw-region-item').forEach(el => {
            const itemFlag = el.getAttribute('data-flag');
            if (flag === 'all' || itemFlag === flag) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });

        // 3. Filter Table Rows
        document.querySelectorAll('.hw-table-row').forEach(row => {
            const itemFlag = row.getAttribute('data-flag');
            if (flag === 'all' || itemFlag === flag) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    };

    // Retry button handler
    const retryBtn = document.getElementById('map-retry-btn');
    if (retryBtn) {
        retryBtn.addEventListener('click', () => {
            initMap();
        });
    }

    initMap();
});
