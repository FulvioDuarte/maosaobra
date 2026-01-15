#!/bin/sh
# Testa se Laravel responde na porta do container
if curl -s http://localhost:8080 | grep -q "Laravel"; then
    echo "Laravel está funcionando ✅"
else
    echo "Laravel NÃO está respondendo ❌"
fi
