import * as maplibregl from 'maplibre-gl';
import 'maplibre-gl/dist/maplibre-gl.css';

document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('maplibre-container');
    if (!mapContainer) return;

    // Offline style definition: clean canvas without external tiles
    const map = new maplibregl.Map({
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
        center: [109.35, -7.45], // Central Java Banyumas region coordinates
        zoom: 8.5,
        attributionControl: false,
    });

    map.addControl(new maplibregl.NavigationControl({ showCompass: false }), 'top-right');

    map.on('load', async () => {
        try {
            const response = await fetch('/api/v1/map/choropleth');
            const geojson = await response.json();

            map.addSource('regions-choropleth', {
                type: 'geojson',
                data: geojson,
            });

            // Fill layer colored by flag
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
                    'fill-opacity': 0.75,
                },
            });

            // Boundary line layer
            map.addLayer({
                id: 'regions-line',
                type: 'line',
                source: 'regions-choropleth',
                paint: {
                    'line-color': '#0f172a',
                    'line-width': 1.5,
                },
            });

            // Hover highlight layer
            map.addLayer({
                id: 'regions-highlight',
                type: 'line',
                source: 'regions-choropleth',
                paint: {
                    'line-color': '#0f766e',
                    'line-width': 3,
                },
                filter: ['==', 'bps_code', ''],
            });

            const popup = new maplibregl.Popup({
                closeButton: false,
                closeOnClick: false,
                className: 'hw-map-popup',
            });

            map.on('mousemove', 'regions-fill', (e) => {
                if (e.features && e.features.length > 0) {
                    map.getCanvas().style.cursor = 'pointer';
                    const f = e.features[0];
                    const p = f.properties;

                    map.setFilter('regions-highlight', ['==', 'bps_code', p.bps_code]);

                    const popupHtml = `
                        <div style="font-family: Inter, sans-serif; padding: 6px 10px; font-size: 12px; min-width: 170px;">
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
                            <div style="display: flex; justify-content: space-between; margin-top: 6px; padding-top: 4px; border-top: 1px solid #e2e8f0;">
                                <span style="color: #64748b;">Rasio Relatif:</span>
                                <span style="font-weight: 700; color: #0f766e;">${p.relative_ratio}x</span>
                            </div>
                            <div style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #1e293b;">
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

            // Map Filter Buttons
            window.hwFilterMap = (flag) => {
                if (flag === 'all') {
                    map.setFilter('regions-fill', null);
                    map.setFilter('regions-line', null);
                } else {
                    map.setFilter('regions-fill', ['==', 'flag', flag]);
                    map.setFilter('regions-line', ['==', 'flag', flag]);
                }
            };
        } catch (err) {
            console.error('Error loading choropleth data:', err);
        }
    });
});
