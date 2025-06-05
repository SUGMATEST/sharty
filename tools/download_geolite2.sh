cd /var/www/soyjakparty/inc/lib/geoip2/
curl -O -J -L -u 1089206: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 https://download.maxmind.com/geoip/databases/GeoLite2-City/download?suffix=tar.gz
gzip -d GeoLite2-City_*.tar.gz
tar -xf GeoLite2-City_*.tar
mv GeoLite2-City_*/GeoLite2-City.mmdb ./
rm -r GeoLite2-City_*
