<style>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 10px;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* HEADER COMPACTO */
        .header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 5px;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .header-title {
            flex: 1;
            min-width: 200px;
        }

        .header-title h1 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .refresh-info {
            font-size: 13px;
            opacity: 0.9;

            display: flex;
            align-items: center;
            gap: 8px;
        }

        #lastUpdate {
            background: rgba(255, 255, 255, 0.2);
            padding: 3px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        /* ESTATÍSTICAS NO HEADER */
        .header-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }

        .stat-item {
            text-align: center;
            min-width: 80px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .stat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* GRID DE CARDS */
        .grid-os {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(333px, 1fr));
            gap: 5px;
            width: 100%;


        }


        .os-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            border-color: #d1e3ff;
        }

        /* CARD HEADER */


        .os-id {
            color: #0c274e;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 8px;
        }



        .indicador-urgencia {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }

        /* CARD CONTENT */
        .card-content {
            flex-grow: 1;
            margin-bottom: 20px;
        }

        .info-group {
            margin-bottom: 0px;
            margin-top: 1px;
            overflow: hidden;
            height: auto;
        }

        .info-label {
            display: block;
            font-size: 12px;
            color: #718096;
            font-weight: 600;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #2d3748;
            font-size: 14px;
            line-height: 1.5;
        }

        .periodo-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0px;
            margin-top: -3px;
        }


        /* IMAGEM */
        .imagem-container {
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .imagem-container:hover {
            border-color: #0d6efd;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
        }

        .imagem-os {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .imagem-os:hover {
            transform: scale(1.02);
        }

        /* CARD FOOTER */
        .card-footer {
            margin-top: auto;
        }

        .alerta-container {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffd43b;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(255, 212, 59, 0.4);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(255, 212, 59, 0);
            }
        }

        .alerta-texto {
            color: #856404;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .btn-checar {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-checar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .btn-falar {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-falar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        /* BADGES DE STATUS */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .badge-pendente {
            background: #ffc107;
            color: #856404;
        }

        .badge-verificado {
            background: rgb(40, 167, 69, 0.6);
            color: white;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 1200px) {
            .grid-os {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .header-title {
                min-width: 100%;
            }

            .header-stats {
                justify-content: center;
                width: 100%;
            }

            .stat-item {
                flex: 1;
                min-width: 70px;
            }

            .grid-os {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 8px;
            }

            .os-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 20px;
            }
        }

        /* CORES DE URGÊNCIA */
        .urgencia-5 {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
        }

        .urgencia-4 {
            background: linear-gradient(135deg, #ffd93d 0%, #ffc107 100%);
        }

        .urgencia-3 {
            background: linear-gradient(135deg, #6bc5ff 0%, #4d96ff 100%);
        }

        .urgencia-2 {
            background: linear-gradient(135deg, #4d96ff 0%, #1e7af0 100%);
        }

        .urgencia-1 {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }

        /*  Mensagem toolbar*/
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeLoop 20s linear infinite;
        }

        .marquee-track span {
            padding-right: 50px;
            white-space: nowrap;
            color: #fff;
            font-weight: 600;
        }

        @keyframes marqueeLoop {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }
    </style>
</style>