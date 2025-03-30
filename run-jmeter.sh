#!/bin/bash
echo "🧹 Cleaning old report..."
#mkdir -p jmeter/report
rm -rf jmeter/report/*
rm -rf jmeter/result.jtl

echo "🚀 Running JMeter test..."
docker-compose run --rm jmeter \
  -n -t /jmeter/testplans/my-api-test.jmx \
  -l /jmeter/result.jtl \
  -e -o /jmeter/report

echo "✅ Done! Open http://localhost/jmeter/report/index.html"
