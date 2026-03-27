Título do Projeto: Sistema de Agendamento de Quadras e Espaços de Lazer
Resumo do Projeto
O presente projeto tem como objetivo desenvolver um sistema de agendamento para quadras esportivas e espaços de lazer. A plataforma permitirá que usuários realizem reservas de quadra de futebol society e quadra de vôlei de forma simples e organizada. Além do agendamento das quadras, o sistema oferecerá a opção de locação de equipamentos esportivos, como bola de futebol e chuteira para a quadra de futebol, e bola de vôlei e viseira para a quadra de vôlei.

O sistema também contará com a disponibilidade de três espaços com churrasqueira para locação, permitindo que os usuários reservem áreas destinadas a confraternizações e eventos. Além disso, haverá integração com um bar local dentro do espaço, possibilitando a compra de produtos como cerveja, água, refrigerantes e sucos.

O objetivo principal do projeto é facilitar o gerenciamento das reservas, melhorar a organização do espaço esportivo e proporcionar maior comodidade aos usuários, centralizando em um único sistema todas as opções de agendamento, locação de equipamentos e compra de produtos.



uml

Usuario
- id
- nome
- email
- telefone
- fazerReserva()
- alugarEquipamento()
- comprarProduto()

        |
        | faz
        v

Reserva
- id
- data
- horario
- status
- confirmar()
- cancelar()

Reserva --> Quadra
Reserva --> EspacoLazer

Quadra
- id
- nome
- tipo
- disponivel

EspacoLazer
- id
- nome
- capacidade
- disponivel

Equipamento
- id
- nome
- tipo
- disponivel

Bar
- id
- nome

Bar --> Produto

Produto
- id
- nome
- preco
- estoque
