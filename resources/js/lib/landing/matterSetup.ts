import Matter from 'matter-js';

export interface BallData {
    label: string;
    color: 'red' | 'yellow' | 'green';
}

export const terribleIdeas = [
    'Blockchain for Cats',
    'Uber for Houseplants',
    'AI-Powered Socks',
    'Tinder for Pets',
    'Instagram for Ants',
    'Netflix for Dreams',
    'Airbnb for Bathrooms',
    'Pet Rock 2.0',
    'Cryptocurrency for Toddlers',
    'Smart Spatula',
    'IoT Doormat',
    'AR Sticky Notes',
    'VR Umbrella',
    'NFT Lunch Boxes',
    'Metaverse Garage Sale',
    'Podcast for Plants',
    'TikTok for Seniors',
    'LinkedIn for Pets',
    'Uber for Groceries', // Wait...
    'Food Delivery App', // Hmm...
    'Marketplace for Used Goods', // Actually...
    'Photo Sharing App', // These exist!
];

export function createBallPitWorld(canvas: HTMLCanvasElement, isMobile: boolean) {
    const Engine = Matter.Engine;
    const Render = Matter.Render;
    const World = Matter.World;
    const Bodies = Matter.Bodies;
    const Mouse = Matter.Mouse;
    const MouseConstraint = Matter.MouseConstraint;
    const Events = Matter.Events;

    // Create engine
    const engine = Engine.create();
    engine.gravity.y = 1;

    // Create renderer
    const render = Render.create({
        canvas: canvas,
        engine: engine,
        options: {
            width: canvas.clientWidth,
            height: canvas.clientHeight,
            wireframes: false,
            background: 'transparent',
        },
    });

    // Create walls
    const wallOptions = { isStatic: true, render: { fillStyle: 'transparent' } };
    const walls = [
        Bodies.rectangle(canvas.clientWidth / 2, 0, canvas.clientWidth, 20, wallOptions), // top
        Bodies.rectangle(canvas.clientWidth / 2, canvas.clientHeight, canvas.clientWidth, 20, wallOptions), // bottom
        Bodies.rectangle(0, canvas.clientHeight / 2, 20, canvas.clientHeight, wallOptions), // left
        Bodies.rectangle(canvas.clientWidth, canvas.clientHeight / 2, 20, canvas.clientHeight, wallOptions), // right
    ];

    // Create balls
    const totalBalls = isMobile ? 80 : 150;
    const redCount = Math.floor(totalBalls * 0.7);
    const yellowCount = Math.floor(totalBalls * 0.25);
    const greenCount = totalBalls - redCount - yellowCount;

    const balls: Matter.Body[] = [];
    const ballData = new Map<Matter.Body, BallData>();

    const colorConfigs = [
        { count: redCount, color: 'red' as const, fillStyle: 'hsl(0, 70%, 55%)' },
        { count: yellowCount, color: 'yellow' as const, fillStyle: 'hsl(45, 90%, 60%)' },
        { count: greenCount, color: 'green' as const, fillStyle: 'hsl(142, 60%, 50%)' },
    ];

    let ideaIndex = 0;
    colorConfigs.forEach(({ count, color, fillStyle }) => {
        for (let i = 0; i < count; i++) {
            const radius = isMobile ? 15 : 20;
            const x = Math.random() * (canvas.clientWidth - 100) + 50;
            const y = Math.random() * (canvas.clientHeight - 100) + 50;

            const ball = Bodies.circle(x, y, radius, {
                restitution: 0.8,
                friction: 0.001,
                density: 0.001,
                render: {
                    fillStyle: fillStyle,
                },
            });

            balls.push(ball);
            ballData.set(ball, {
                label: terribleIdeas[ideaIndex % terribleIdeas.length],
                color: color,
            });
            ideaIndex++;
        }
    });

    // Add all bodies to world
    World.add(engine.world, [...walls, ...balls]);

    // Add mouse control
    const mouse = Mouse.create(render.canvas);
    const mouseConstraint = MouseConstraint.create(engine, {
        mouse: mouse,
        constraint: {
            stiffness: 0.2,
            render: {
                visible: false,
            },
        },
    });

    World.add(engine.world, mouseConstraint);

    // Keep the mouse in sync with rendering
    render.mouse = mouse;

    // Run the engine and renderer
    const runner = Matter.Runner.create();
    Matter.Runner.run(runner, engine);
    Render.run(render);

    return {
        engine,
        render,
        runner,
        balls,
        ballData,
        cleanup: () => {
            Matter.Runner.stop(runner);
            Render.stop(render);
            World.clear(engine.world, false);
            Engine.clear(engine);
            render.canvas.remove();
        },
    };
}

export function handleResize(
    canvas: HTMLCanvasElement,
    render: Matter.Render,
    engine: Matter.Engine
) {
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;

    // Update canvas
    canvas.width = width;
    canvas.height = height;

    // Update render bounds
    render.bounds.max.x = width;
    render.bounds.max.y = height;
    render.options.width = width;
    render.options.height = height;
    render.canvas.width = width;
    render.canvas.height = height;

    // Update walls
    const walls = engine.world.bodies.filter((body) => body.isStatic);
    if (walls.length >= 4) {
        Matter.Body.setPosition(walls[0], { x: width / 2, y: 0 });
        Matter.Body.setPosition(walls[1], { x: width / 2, y: height });
        Matter.Body.setPosition(walls[2], { x: 0, y: height / 2 });
        Matter.Body.setPosition(walls[3], { x: width, y: height / 2 });
    }
}
