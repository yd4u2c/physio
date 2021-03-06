<?php

namespace Faker\Provider\es_AR;

class Address extends \Faker\Provider\es_ES\Address
{
    protected static $cityPrefix = array('San', 'Puerto', 'Villa', 'Gral.', 'Don');
    protected static $citySuffix = array('del Mar', 'del Norte', 'del Este', 'del Sur', 'del Oeste', 'del Mirador');
    protected static $buildingNumber = array('#####', '####', '###', '##', '#');
    protected static $streetSuffix = array('');
    protected static $postcode = array('####', '#####');
    protected static $state = array(
        'Buenos Aires', 'Catamarca', 'Chaco', 'Chubut', 'Córdoba', 'Corrientes', 'Entre Ríos', 'Formosa', 'Jujuy', 'La Pampa', 'La Rioja', 'Mendoza', 'Misiones', 'Neuquén', 'Río Negro', 'Salta', 'San Juan', 'San Luis', 'Santa Cruz', 'Santa Fe', 'Santiago del Estero', 'Tierra del Fuego, Antártida e Islas del Atlántico Sur', 'Tucumán'
    );
    protected static $stateAbbr = array(
        'AR-B', 'AR-K', 'AR-H', 'AR-U', 'AR-X', 'AR-W', 'AR-E', 'AR-P', 'AR-Y', 'AR-L', 'AR-F', 'AR-M', 'AR-N', 'AR-Q', 'AR-R', 'AR-A', 'AR-J', 'AR-D', 'AR-Z', 'AR-S', 'AR-G', 'AR-V', 'AR-T'
    );
    protected static $cityFormats = array(
        '{{cityPrefix}} {{firstName}} {{citySuffix}}',
        '{{cityPrefix}} {{firstName}}',
        '{{firstName}} {{citySuffix}}',
        '{{lastName}} {{citySuffix}}',
    );
    protected static $streetNameFormats = array(
        '{{firstName}} {{streetSuffix}}',
        '{{lastName}} {{streetSuffix}}'
    );
    protected static $streetAddressFormats = array(
        '{{streetName}} {{buildingNumber}}',
        '{{streetName}} {{buildingNumber}} {{secondaryAddress}}',
    );
    protected static $addressFormats = array(
        "{{streetAddress}}\n{{city}}, {{stateAbbr}} {{postcode}}",
    );
    protected static $secondaryAddressFormats = array('Depto. ###', 'Hab. ###', 'Piso #', 'Piso ##', 'PB A', '# A', '# B', '# C', '# D', '# E', '# F', '## A', '## B', '## C', '## D', '## E', '## F', '# #', '## #');

    /**
     * @example 'San'
     */
    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    /**
     * @example '3ºA'
     */
    public static function secondaryAddress()
    {
        return static::numerify(static::randomElement(static::$secondaryAddressFormats));
    }

    /**
     * @example 'Buenos Aires'
     */
    public static function state()
    {
        return static::randomElement(static::$state);
    }

    /**
     * @example 'AR-B'
     */
    public static function stateAbbr()
    {
        return static::randomElement(static::$stateAbbr);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Faker\Provider\es_AR;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{lastName}}-{{lastName}}',
        '{{lastName}} y {{lastName}}',
        '{{lastName}} de {{lastName}}',
        '{{lastName}}, {{lastName}} y {{lastName}}'
    );

    protected static $catchPhraseWords = array(
        array(
            'Adaptive', 'Advanced', 'Ameliorated', 'Assimilated', 'Automated', 'Balanced', 'Business-focused', 'Centralized', 'Cloned', 'Compatible', 'Configurable', 'Cross-group', 'Cross-platform', 'Customer-focused', 'Customizable', 'Decentralized', 'De-engineered', 'Devolved', 'Digitized', 'Distributed', 'Diverse', 'Down-sized', 'Enhanced', 'Enterprise-wide', 'Ergonomic', 'Exclusive', 'Expanded', 'Extended', 'Facetoface', 'Focused', 'Front-line', 'Fully-configurable', 'Function-based', 'Fundamental', 'Future-proofed', 'Grass-roots', 'Horizontal', 'Implemented', 'Innovative', 'Integrated', 'Intuitive', 'Inverse', 'Managed', 'Mandatory', 'Monitored', 'Multi-channelled', 'Multi-lateral', 'Multi-layered', 'Multi-tiered', 'Networked', 'Object-based', 'Open-architected', 'Open-source', 'Operative', 'Optimized', 'Optional', 'Organic', 'Organized', 'Persevering', 'Persistent', 'Phased', 'Polarised', 'Pre-emptive', 'Proactive', 'Profit-focused', 'Profound', 'Programmable', 'Progressive', 'Public-key', 'Quality-focused', 'Reactive', 'Realigned', 'Re-contextualized', 'Re-engineered', 'Reduced', 'Reverse-engineered', 'Right-sized', 'Robust', 'Seamless', 'Secured', 'Self-enabling', 'Sharable', 'Stand-alone', 'Streamlined', 'Switchable', 'Synchronised', 'Synergistic', 'Synergized', 'Team-oriented', 'Total', 'Triple-buffered', 'Universal', 'Up-sized', 'Upgradable', 'User-centric', 'User-friendly', 'Versatile', 'Virtual', 'Visionary', 'Vision-oriented'
        ),
        array(
            '24hour', '24/7', '3rdgeneration', '4thgeneration', '5thgeneration', '6thgeneration', 'actuating', 'analyzing', 'assymetric', 'asynchronous', 'attitude-oriented', 'background', 'bandwidth-monitored', 'bi-directional', 'bifurcated', 'bottom-line', 'clear-thinking', 'client-driven', 'client-server', 'coherent', 'cohesive', 'composite', 'context-sensitive', 'contextually-based', 'content-based', 'dedicated', 'demand-driven', 'didactic', 'directional', 'discrete', 'disintermediate', 'dynamic', 'eco-centric', 'empowering', 'encompassing', 'even-keeled', 'executive', 'explicit', 'exuding', 'fault-tolerant', 'foreground', 'fresh-thinking', 'full-range', 'global', 'grid-enabled', 'heuristic', 'high-level', 'holistic', 'homogeneous', 'human-resource', 'hybrid', 'impactful', 'incremental', 'intangible', 'interactive', 'intermediate', 'leadingedge', 'local', 'logistical', 'maximized', 'methodical', 'mission-critical', 'mobile', 'modular', 'motivating', 'multimedia', 'multi-state', 'multi-tasking', 'national', 'needs-based', 'neutral', 'nextgeneration', 'non-volatile', 'object-oriented', 'optimal', 'optimizing', 'radical', 'real-time', 'reciprocal', 'regional', 'responsive', 'scalable', 'secondary', 'solution-oriented', 'stable', 'static', 'systematic', 'systemic', 'system-worthy', 'tangible', 'tertiary', 'transitional', 'uniform', 'upward-trending', 'user-facing', 'value-added', 'web-enabled', 'well-modulated', 'zeroadministration', 'zerodefect', 'zerotolerance'
        ),
        array(
            'ability', 'access', 'adapter', 'algorithm', 'alliance', 'analyzer', 'application', 'approach', 'architecture', 'archive', 'artificialintelligence', 'array', 'attitude', 'benchmark', 'budgetarymanagement', 'capability', 'capacity', 'challenge', 'circuit', 'collaboration', 'complexity', 'concept', 'conglomeration', 'contingency', 'core', 'customerloyalty', 'database', 'data-warehouse', 'definition', 'emulation', 'encoding', 'encryption', 'extranet', 'firmware', 'flexibility', 'focusgroup', 'forecast', 'frame', 'framework', 'function', 'functionalities', 'GraphicInterface', 'groupware', 'GraphicalUserInterface', 'hardware', 'help-desk', 'hierarchy', 'hub', 'implementation', 'info-mediaries', 'infrastructure', 'initiative', 'installation', 'instructionset', 'interface', 'internetsolution', 'intranet', 'knowledgeuser', 'knowledgebase', 'localareanetwork', 'leverage', 'matrices', 'matrix', 'methodology', 'middleware', 'migration', 'model', 'moderator', 'monitoring', 'moratorium', 'neural-net', 'openarchitecture', 'opensystem', 'orchestration', 'paradigm', 'parallelism', 'policy', 'portal', 'pricingstructure', 'processimprovement', 'product', 'productivity', 'project', 'projection', 'protocol', 'securedline', 'service-desk', 'software', 'solution', 'standardization', 'strategy', 'structure', 'success', 'superstructure', 'support', 'synergy', 'systemengine', 'task-force', 'throughput', 'time-frame', 'toolset', 'utilisation', 'website', 'workforce'
        )
    );

    protected static $bsWords = array(
        array(
            'implement', 'utilize', 'integrate', 'streamline', 'optimize', 'evolve', 'transform', 'embrace', 'enable', 'orchestrate', 'leverage', 'reinvent', 'aggregate', 'architect', 'enhance', 'incentivize', 'morph', 'empower', 'envisioneer', 'monetize', 'harness', 'facilitate', 'seize', 'disintermediate', 'synergize', 'strategize', 'deploy', 'brand', 'grow', 'target', 'syndicate', 'synthesize', 'deliver', 'mesh', 'incubate', 'engage', 'maximize', 'benchmark', 'expedite', 'reintermediate', 'whiteboard', 'visualize', 'repurpose', 'innovate', 'scale', 'unleash', 'drive', 'extend', 'engineer', 'revolutionize', 'generate', 'exploit', 'transition', 'e-enable', 'iterate', 'cultivate', 'matrix', 'productize', 'redefine', 'recontextualize'
        ),
        array(
            'clicks-and-mortar', 'value-added', 'vertical', 'proactive', 'robust', 'revolutionary', 'scalable', 'leading-edge', 'innovative', 'intuitive', 'strategic', 'e-business', 'mission-critical', 'sticky', 'one-to-one', '24/7', 'end-to-end', 'global', 'B2B', 'B2C', 'granular', 'frictionless', 'virtual', 'viral', 'dynamic', '24/365', 'best-of-breed', 'killer', 'magnetic', 'bleeding-edge', 'web-enabled', 'interactive', 'dot-com', 'sexy', 'back-end', 'real-time', 'efficient', 'front-end', 'distributed', 'seamless', 'extensible', 'turn-key', 'world-class', 'open-source', 'cross-platform', 'cross-media', 'synergistic', 'bricks-and-clicks', 'out-of-the-box', 'enterprise', 'integrated', 'impactful', 'wireless', 'transparent', 'next-generation', 'cutting-edge', 'user-centric', 'visionary', 'customized', 'ubiquitous', 'plug-and-play', 'collaborative', 'compelling', 'holistic', 'rich'
        ),
        array(
            'synergies', 'web-readiness', 'paradigms', 'markets', 'partnerships', 'infrastructures', 'platforms', 'initiatives', 'channels', 'eyeballs', 'communities', 'ROI', 'solutions', 'e-tailers', 'e-services', 'action-items', 'portals', 'niches', 'technologies', 'content', 'vortals', 'supply-chains', 'convergence', 'relationships', 'architectures', 'interfaces', 'e-markets', 'e-commerce', 'systems', 'bandwidth', 'infomediaries', 'models', 'mindshare', 'deliverables', 'users', 'schemas', 'networks', 'applications', 'metrics', 'e-business', 'functionalities', 'experiences', 'webservices', 'methodologies'
        )
    );

    protected static $companySuffix = array('e Hijo', 'e Hija', 'e Hijos', 'y Asoc.', 'y Flia.', 'SRL', 'SA', 'S. de H.');

    /**
     * @example 'Robust full-range hub'
     */
    public function catchPhrase()
    {
        $result = array();
        foreach (static::$catchPhraseWords as &$word) {
            $result[] = static::randomElement($word);
        }

        return join($result, ' ');
    }

    /**
     * @example 'integrate extensible convergence'
     */
    public function bs()
    {
        $result = array();
        foreach (static::$bsWords as &$word) {
            $result[] = static::randomElement($word);
        }

        return join($result, ' ');
    }
}
                                                                                                                                                                                                                          <?php

namespace Faker\Provider\es_AR;

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}} {{suffix}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}} {{suffix}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}} {{suffix}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}} {{suffix}}',
    );

    protected static $firstNameMale = array(
        'Aarón', 'Adrián', 'Agustín', 'Alan', 'Alejandro', 'Alex', 'Alexander', 'Alonso', 'Andrés', 'Anthony', 'Antonio', 'Axel', 'Benjamín',
        'Bruno', 'Camilo', 'Carlos', 'Christian', 'Christopher', 'Cristóbal', 'Damián', 'Daniel', 'Dante', 'David', 'Diego', 'Diego Alejandro',
        'Dylan', 'Eduardo', 'Elías', 'Emiliano', 'Emilio', 'Emmanuel', 'Esteban', 'Facundo', 'Felipe', 'Fernando', 'Francisco', 'Franco',
        'Gabriel', 'Gael', 'Hipólito', 'Horacio', 'Hugo', 'Ian', 'Ignacio', 'Isaac', 'Ivan', 'Jacobo', 'Javier', 'Jerónimo',
        'Jesús', 'Joaquín', 'Jorge', 'Joshua', 'Josué', 'José', 'Juan', 'Juan David', 'Juan Diego', 'Juan José', 'Juan Manuel', 'Juan Martín',
        'Juan Pablo', 'Juan Sebastián', 'Julián', 'Kevin', 'Lautaro', 'Leonardo', 'Lorenzo', 'Lucas', 'Luciano', 'Luis', 'Manuel', 'Mario',
        'Martín', 'Mateo', 'Matthew', 'Matías', 'Maximiliano', 'Miguel', 'Miguel Ángel', 'Máximo', 'Nahuel', 'Pablo', 'Pedro', 'Rafael',
        'Ricardo', 'Rodrigo', 'Samuel', 'Santiago', 'Santino', 'Sebastián', 'Sergio', 'Simón', 'Thiago', 'Tomas', 'Valentino', 'Valentín',
        'Vicente', 'Bautista', 'Juan Esteban', 'Hidalgo'
    );

    protected static $firstNameFemale = array(
        'Abigail', 'Abril', 'Adriana', 'Agustina', 'Alejandra', 'Alessandra', 'Alexa', 'Allison', 'Alma', 'Amanda', 'Amelia', 'Ana', 'Ana Paula',
        'Ana Sofía', 'Andrea', 'Antonella', 'Antonia', 'Ariadna', 'Ariana', 'Ashley', 'Bianca', 'Camila', 'Carla', 'Carolina', 'Catalina',
        'Clara', 'Constanza', 'Daniela', 'Delfina', 'Elena', 'Elizabeth', 'Emilia', 'Emily', 'Emma', 'Fabiana', 'Florencia', 'Fátima',
        'Gabriela', 'Guadalupe', 'Irene', 'Isabel', 'Isabella', 'Isidora', 'Ivanna', 'Jazmín', 'Josefa', 'Josefina', 'Juana', 'Julia',
        'Juliana', 'Julieta', 'Laura', 'Lola', 'Luana', 'Luciana', 'Lucía', 'Luna', 'Magdalena', 'Maite', 'Malena', 'Manuela',
        'Mariana', 'Mariangel', 'Martina', 'María', 'María Alejandra', 'María Camila', 'María Fernanda', 'María José', 'María Paula', 'Micaela', 'Michelle', 'Miranda',
        'Montserrat', 'Mía', 'Nadia', 'Natalia', 'Nicole', 'Oliva', 'Olivia', 'Ornela', 'Paula', 'Paulina', 'Rafaela', 'Rebeca',
        'Regina', 'Renata', 'Romina', 'Salomé', 'Samantha', 'Sara', 'Silvana', 'Sofía', 'Sophie', 'Valentina', 'Valeria', 'Valery',
        'Victoria', 'Violeta', 'Zoe', 'Aitana', 'Sara Sofía', 'Ximena'
    );

    protected static $lastName = array(
        'Abeyta', 'Abrego', 'Abreu', 'Acevedo', 'Acosta', 'Acuña', 'Adame', 'Adorno', 'Agosto', 'Aguayo', 'Águilar', 'Aguilera', 'Aguirre', 'Alanis', 'Alaniz', 'Alarcón', 'Alba', 'Alcala', 'Alcántar', 'Alcaraz', 'Alejandro', 'Alemán', 'Alfaro', 'Alicea', 'Almanza', 'Almaraz', 'Almonte', 'Alonso', 'Alonzo', 'Altamirano', 'Alva', 'Alvarado', 'Álvarez', 'Amador', 'Amaya', 'Anaya', 'Anguiano', 'Angulo', 'Aparicio', 'Apodaca', 'Aponte', 'Aragón', 'Araña', 'Aranda', 'Arce', 'Archuleta', 'Arellano', 'Arenas', 'Arevalo', 'Arguello', 'Arias', 'Armas', 'Armendáriz', 'Armenta', 'Armijo', 'Arredondo', 'Arreola', 'Arriaga', 'Arroyo', 'Arteaga', 'Atencio', 'Ávalos', 'Ávila', 'Avilés', 'Ayala',
        'Baca', 'Badillo', 'Báez', 'Baeza', 'Bahena', 'Balderas', 'Ballesteros', 'Banda', 'Bañuelos', 'Barajas', 'Barela', 'Barragán', 'Barraza', 'Barrera', 'Barreto', 'Barrientos', 'Barrios', 'Batista', 'Becerra', 'Beltrán', 'Benavides', 'Benavídez', 'Benítez', 'Bermúdez', 'Bernal', 'Berríos', 'Bétancourt', 'Blanco', 'Bonilla', 'Borrego', 'Botello', 'Bravo', 'Briones', 'Briseño', 'Brito', 'Bueno', 'Burgos', 'Bustamante', 'Bustos',
        'Caballero', 'Cabán', 'Cabrera', 'Cadena', 'Caldera', 'Calderón', 'Calvillo', 'Camacho', 'Camarillo', 'Campos', 'Canales', 'Candelaria', 'Cano', 'Cantú', 'Caraballo', 'Carbajal', 'Cardenas', 'Cardona', 'Carmona', 'Carranza', 'Carrasco', 'Carrasquillo', 'Carreón', 'Carrera', 'Carrero', 'Carrillo', 'Carrion', 'Carvajal', 'Casanova', 'Casares', 'Casárez', 'Casas', 'Casillas', 'Castañeda', 'Castellanos', 'Castillo', 'Castro', 'Cavazos', 'Cazares', 'Ceballos', 'Cedillo', 'Ceja', 'Centeno', 'Cepeda', 'Cerda', 'Cervantes', 'Cervántez', 'Chacón', 'Chapa', 'Chavarría', 'Chávez', 'Cintrón', 'Cisneros', 'Collado', 'Collazo', 'Colón', 'Colunga', 'Concepción', 'Contreras', 'Cordero', 'Córdova', 'Cornejo', 'Corona', 'Coronado', 'Corral', 'Corrales', 'Correa', 'Cortés', 'Cortez', 'Cotto', 'Covarrubias', 'Crespo', 'Cruz', 'Cuellar', 'Curiel',
        'Dávila', 'de Anda', 'de Jesús', 'Delacrúz', 'Delafuente', 'Delagarza', 'Delao', 'Delapaz', 'Delarosa', 'Delatorre', 'Deleón', 'Delgadillo', 'Delgado', 'Delrío', 'Delvalle', 'Díaz', 'Domínguez', 'Domínquez', 'Duarte', 'Dueñas', 'Duran',
        'Echevarría', 'Elizondo', 'Enríquez', 'Escalante', 'Escamilla', 'Escobar', 'Escobedo', 'Esparza', 'Espinal', 'Espino', 'Espinosa', 'Espinoza', 'Esquibel', 'Esquivel', 'Estévez', 'Estrada',
        'Fajardo', 'Farías', 'Feliciano', 'Fernández', 'Ferrer', 'Fierro', 'Figueroa', 'Flores', 'Flórez', 'Fonseca', 'Franco', 'Frías', 'Fuentes',
        'Gaitán', 'Galarza', 'Galindo', 'Gallardo', 'Gallegos', 'Galván', 'Gálvez', 'Gamboa', 'Gamez', 'Gaona', 'Garay', 'García', 'Garibay', 'Garica', 'Garrido', 'Garza', 'Gastélum', 'Gaytán', 'Gil', 'Girón', 'Godínez', 'Godoy', 'Gómez', 'Gonzales', 'González', 'Gracia', 'Granado', 'Granados', 'Griego', 'Grijalva', 'Guajardo', 'Guardado', 'Guerra', 'Guerrero', 'Guevara', 'Guillen', 'Gurule', 'Gutiérrez', 'Guzmán',
        'Haro', 'Henríquez', 'Heredia', 'Hernádez', 'Hernandes', 'Hernández', 'Herrera', 'Hidalgo', 'Hinojosa', 'Holguín', 'Huerta', 'Hurtado',
        'Ibarra', 'Iglesias', 'Irizarry',
        'Jaime', 'Jaimes', 'Jáquez', 'Jaramillo', 'Jasso', 'Jiménez', 'Jimínez', 'Juárez', 'Jurado',
        'Laboy', 'Lara', 'Laureano', 'Leal', 'Lebrón', 'Ledesma', 'Leiva', 'Lemus', 'León', 'Lerma', 'Leyva', 'Limón', 'Linares', 'Lira', 'Llamas', 'Loera', 'Lomeli', 'Longoria', 'López', 'Lovato', 'Loya', 'Lozada', 'Lozano', 'Lucero', 'Lucio', 'Luevano', 'Lugo', 'Luján', 'Luna',
        'Macías', 'Madera', 'Madrid', 'Madrigal', 'Maestas', 'Magaña', 'Malave', 'Maldonado', 'Manzanares', 'Mares', 'Marín', 'Márquez', 'Marrero', 'Marroquín', 'Martínez', 'Mascareñas', 'Mata', 'Mateo', 'Matías', 'Matos', 'Maya', 'Mayorga', 'Medina', 'Medrano', 'Mejía', 'Meléndez', 'Melgar', 'Mena', 'Menchaca', 'Méndez', 'Mendoza', 'Menéndez', 'Meraz', 'Mercado', 'Merino', 'Mesa', 'Meza', 'Miramontes', 'Miranda', 'Mireles', 'Mojica', 'Molina', 'Mondragón', 'Monroy', 'Montalvo', 'Montañez', 'Montaño', 'Montemayor', 'Montenegro', 'Montero', 'Montes', 'Montez', 'Montoya', 'Mora', 'Morales', 'Moreno', 'Mota', 'Moya', 'Munguía', 'Muñiz', 'Muñoz', 'Murillo', 'Muro',
        'Nájera', 'Naranjo', 'Narváez', 'Nava', 'Navarrete', 'Navarro', 'Nazario', 'Negrete', 'Negrón', 'Nevárez', 'Nieto', 'Nieves', 'Niño', 'Noriega', 'Núñez',
        'Ocampo', 'Ocasio', 'Ochoa', 'Ojeda', 'Olivares', 'Olivárez', 'Olivas', 'Olivera', 'Olivo', 'Olmos', 'Olvera', 'Ontiveros', 'Oquendo', 'Ordóñez', 'Orellana', 'Ornelas', 'Orosco', 'Orozco', 'Orta', 'Ortega', 'Ortiz', 'Osorio', 'Otero', 'Ozuna',
        'Pabón', 'Pacheco', 'Padilla', 'Padrón', 'Páez', 'Pagan', 'Palacios', 'Palomino', 'Palomo', 'Pantoja', 'Paredes', 'Parra', 'Partida', 'Patiño', 'Paz', 'Pedraza', 'Pedroza', 'Pelayo', 'Peña', 'Perales', 'Peralta', 'Perea', 'Peres', 'Pérez', 'Pichardo', 'Piña', 'Pineda', 'Pizarro', 'Polanco', 'Ponce', 'Porras', 'Portillo', 'Posada', 'Prado', 'Preciado', 'Prieto', 'Puente', 'Puga', 'Pulido',
        'Quesada', 'Quezada', 'Quiñones', 'Quiñónez', 'Quintana', 'Quintanilla', 'Quintero', 'Quiroz',
        'Rael', 'Ramírez', 'Ramón', 'Ramos', 'Rangel', 'Rascón', 'Raya', 'Razo', 'Regalado', 'Rendón', 'Rentería', 'Reséndez', 'Reyes', 'Reyna', 'Reynoso', 'Rico', 'Rincón', 'Riojas', 'Ríos', 'Rivas', 'Rivera', 'Rivero', 'Robledo', 'Robles', 'Rocha', 'Rodarte', 'Rodrígez', 'Rodríguez', 'Rodríquez', 'Rojas', 'Rojo', 'Roldán', 'Rolón', 'Romero', 'Romo', 'Roque', 'Rosado', 'Rosales', 'Rosario', 'Rosas', 'Roybal', 'Rubio', 'Ruelas', 'Ruiz', 'Ruvalcaba',
        'Saavedra', 'Sáenz', 'Saiz', 'Salas', 'Salazar', 'Salcedo', 'Salcido', 'Saldaña', 'Saldivar', 'Salgado', 'Salinas', 'Samaniego', 'Sanabria', 'Sanches', 'Sánchez', 'Sandoval', 'Santacruz', 'Santana', 'Santiago', 'Santillán', 'Sarabia', 'Sauceda', 'Saucedo', 'Sedillo', 'Segovia', 'Segura', 'Sepúlveda', 'Serna', 'Serrano', 'Serrato', 'Sevilla', 'Sierra', 'Sisneros', 'Solano', 'Solís', 'Soliz', 'Solorio', 'Solorzano', 'Soria', 'Sosa', 'Sotelo', 'Soto', 'Suárez',
        'Tafoya', 'Tamayo', 'Tamez', 'Tapia', 'Tejada', 'Tejeda', 'Téllez', 'Tello', 'Terán', 'Terrazas', 'Tijerina', 'Tirado', 'Toledo', 'Toro', 'Torres', 'Tórrez', 'Tovar', 'Trejo', 'Treviño', 'Trujillo',
        'Ulibarri', 'Ulloa', 'Urbina', 'Ureña', 'Urías', 'Uribe', 'Urrutia',
        'Vaca', 'Valadez', 'Valdés', 'Valdez', 'Valdivia', 'Valencia', 'Valentín', 'Valenzuela', 'Valladares', 'Valle', 'Vallejo', 'Valles', 'Valverde', 'Vanegas', 'Varela', 'Vargas', 'Vásquez', 'Vázquez', 'Vega', 'Vela', 'Velasco', 'Velásquez', 'Velázquez', 'Vélez', 'Véliz', 'Venegas', 'Vera', 'Verdugo', 'Verduzco', 'Vergara', 'Viera', 'Vigil', 'Villa', 'Villagómez', 'Villalobos', 'Villalpando', 'Villanueva', 'Villareal', 'Villarreal', 'Villaseñor', 'Villegas',
        'Yáñez', 'Ybarra',
        'Zambrano', 'Zamora', 'Zamudio', 'Zapata', 'Zaragoza', 'Zarate', 'Zavala', 'Zayas', 'Zelaya', 'Zepeda', 'Zúñiga'
    );

    protected static $titleMale = array('Sr.', 'Dn.', 'Dr.', 'Lic.', 'Ing.');

    protected static $titleFemale = array('Sra.', 'Srita.', 'Dr.', 'Lic.', 'Ing.');

    private static $suffix = array('Hijo', 'Segundo', 'Tercero');

    /**
     * @example 'Hijo'
     */
    public static function suffix()
    {
        return static::randomElement(static::$suffix);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Faker\Provider\es_AR;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '+##(#)##########',
        '+##(#)##########',
        '###-###-####',
        '(##)4###-####',
        '(##)4###-####',
        '(##)4###-####',
        '(##)4###-####',
        '(##)154###-####',
        '(##)5###-####',
        '(##)5###-####',
        '(##)155###-####',
        '(##)155###-####',
        '(##)155###-####',
        '(##)6###-####',
        '(###)4##-####',
        '(###)4##-####',
        '(###)4##-####',
        '(###)5##-####',
        '(###)5##-####',
        '(###)5##-####',
        '(###)154##-####',
        '(###)154##-####',
        '(###)155##-####',
        '(###)155##-####',
        '(###)155##-####',
        '(####)4#-####',
        '(####)4#-####',
        '(####)4#-####',
        '(####)4#-####',
        '(####)154#-####',
        '(####)154#-####',
        '(####)154#-####',
        '(####)155#-####',
    );
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Faker\Provider\es_ES;

class Address extends \Faker\Provider\Address
{
    protected static $cityPrefix = array('San', 'Vall', "L'", 'Villa', 'El', 'Los', 'La', 'Las', 'O', 'A', 'Os', 'As');
    protected static $citySuffix = array('del Vallès', 'del Penedès', 'del Bages', 'de Ulla', 'de Lemos', 'del Mirador', 'de Arriba', 'de la Sierra', 'del Barco', 'de San Pedro', 'del Pozo', 'del Puerto', 'de las Torres', 'Alta', 'Baja', 'Medio');
    protected static $buildingNumber = array('###', '##', '#');
    protected static $streetPrefix = array(
        'Calle', 'Avenida', 'Plaza', 'Paseo', 'Ronda', 'Travesía', 'Camino', 'Carrer', 'Avinguda', 'Plaça', 'Passeig', 'Travessera', 'Rúa', 'Praza', 'Ruela', 'Camiño'
    );
    protected static $postcode = array('#####');
    protected static $community = array(
        'Andalucía', 'Aragón', 'Principado de Asturias', 'Illes Balears', 'Canarias', 'Cantabria', 'Castilla y León', 'Castilla - La Mancha', 'Cataluña', 'Comunitat Valenciana', 'Extremadura', 'Galicia', 'Comunidad de Madrid', 'Región de Murcia', 'Comunidad Foral de Navarra', 'País Vasco', 'La Rioja', 'Ceuta', 'Melilla'
    );
    protected static $state = array(
        'A Coruña', 'Álava', 'Albacete', 'Alicante', 'Almería', 'Asturias', 'Ávila', 'Badajoz', 'Barcelona', 'Burgos', 'Cáceres', 'Cádiz', 'Cantabria', 'Castellón', 'Ceuta', 'Ciudad Real', 'Cuenca', 'Córdoba', 'Girona', 'Granada', 'Guadalajara', 'Guipuzkoa', 'Huelva', 'Huesca', 'Illes Balears', 'Jaén', 'La Rioja', 'Las Palmas', 'León', 'Lleida', 'Lugo', 'Málaga', 'Madrid', 'Melilla', 'Murcia', 'Navarra', 'Ourense', 'Palencia', 'Pontevedra', 'Salamanca', 'Segovia', 'Sevilla', 'Soria', 'Santa Cruz de Tenerife', 'Tarragona', 'Teruel', 'Toledo', 'Valencia', 'Valladolid', 'Vizcaya', 'Zamora', 'Zaragoza'
    );
    protected static $country = array(
        'Afganistán','Albania','Alemania','Andorra','Angola','Antigua y Barbuda','Arabia Saudí','Argelia','Argentina','Armenia','Australia','Austria','Azerbaiyán',
        'Bahamas','Bangladés','Barbados','Baréin','Belice','Benín','Bielorrusia','Birmania','Bolivia','Bosnia-Herzegovina','Botsuana','Brasil','Brunéi Darusalam','Bulgaria','Burkina Faso','Burundi','Bután','Bélgica',
        'Cabo Verde','Camboya','Camerún','Canadá','Catar','Chad','Chile','China','Chipre','Ciudad del Vaticano','Colombia','Comoras','Congo','Corea del Norte','Corea del Sur','Costa Rica','Costa de Marfil','Croacia','Cuba',
        'Dinamarca','Dominica',
        'Ecuador','Egipto','El Salvador','Emiratos Árabes Unidos','Eritrea','Eslovaquia','Eslovenia','España','Estados Unidos de América','Estonia','Etiopía',
        'Filipinas','Finlandia','Fiyi','Francia',
        'Gabón','Gambia','Georgia','Ghana','Granada','Grecia','Guatemala','Guinea','Guinea Ecuatorial','Guinea-Bisáu','Guyana',
        'Haití','Honduras','Hungría',
        'India','Indonesia','Irak','Irlanda','Irán','Islandia','Islas Marshall','Islas Salomón','Israel','Italia',
        'Jamaica','Japón','Jordania',
        'Kazajistán','Kenia','Kirguistán','Kiribati','Kuwait',
        'Laos','Lesoto','Letonia','Liberia','Libia','Liechtenstein','Lituania','Luxemburgo','Líbano',
        'Macedonia','Madagascar','Malasia','Malaui','Maldivas','Mali','Malta','Marruecos','Mauricio','Mauritania','Micronesia','Moldavia','Mongolia','Montenegro','Mozambique','México','Mónaco',
        'Namibia','Nauru','Nepal','Nicaragua','Nigeria','Noruega','Nueva Zelanda','Níger',
        'Omán',
        'Pakistán','Palaos','Panamá','Papúa Nueva Guinea','Paraguay','Países Bajos','Perú','Polonia','Portugal',
        'Reino Unido','Reino Unido de Gran Bretaña e Irlanda del Norte','República Centroafricana','República Checa','República Democrática del Congo','República Dominicana','Ruanda','Rumanía','Rusia',
        'Samoa','San Cristóbal y Nieves','San Marino','San Vicente y las Granadinas','Santa Lucía','Santo Tomé y Príncipe','Senegal','Serbia','Seychelles','Sierra Leona','Singapur','Siria','Somalia','Sri Lanka','Suazilandia','Sudáfrica','Sudán','Suecia','Suiza','Surinam',
        'Tailandia','Tanzania','Tayikistán','Timor Oriental','Togo','Tonga','Trinidad y Tobago','Turkmenistán','Turquía','Tuvalu','Túnez',
        'Ucrania','Uganda','Uruguay','Uzbekistán',
        'Vanuatu','Venezuela','Vietnam',
        'Yemen','Yibuti',
        'Zambia','Zimbabue'
    );
    protected static $cityFormats = array(
        '{{cityPrefix}} {{lastName}} {{citySuffix}}',
        '{{cityPrefix}} {{lastName}}',
        '{{lastName}} {{citySuffix}}',
    );
    protected static $streetNameFormats = array(
        '{{streetPrefix}} {{firstName}}',
        '{{streetPrefix}} {{lastName}}'
    );
    protected static $streetAddressFormats = array(
        '{{streetName}}, {{buildingNumber}}, {{secondaryAddress}}',
    );
    protected static $addressFormats = array(
        "{{streetAddress}}, {{postcode}}, {{city}}"
    );
    protected static $secondaryAddressFormats = array('Bajos', 'Ático #º', 'Entre suelo #º', 'Bajo #º', '#º', '#º A', '#º B', '#º C', '#º D', '#º E', '#º F', '##º A', '##º B', '##º C', '##º D', '##º E', '##º F', '#º #º', '##º #º');

    /**
     * @example 'Avenida'
     */
    public static function streetPrefix()
    {
        return static::randomElement(static::$streetPrefix);
    }

    /**
     * @example 'Villa'
     */
    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    /**
     * @example '3ºA'
     */
    public static function secondaryAddress()
    {
        return static::numerify(static::randomElement(static::$secondaryAddressFormats));
    }

    /**
     * @example 'Barcelona'
     */
    public static function state()
    {
        return static::randomElement(static::$state);
    }

    /**
     * @example 'Comunidad de Madrid'
     */
    public static function community()
    {
        return static::randomElement(static::$community);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Faker\Provider\es_ES;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{companyPrefix}} {{lastName}} {{companySuffix}}',
        '{{companyPrefix}} {{lastName}}',
        '{{companyPrefix}} {{lastName}}-{{lastName}}',
        '{{lastName}}-{{lastName}} {{companySuffix}}',
        '{{lastName}} y {{las