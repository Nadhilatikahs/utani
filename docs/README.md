# System Documentation - Mermaid Diagrams

This directory contains Mermaid diagrams documenting the UsahaTani (Farming Management System) architecture and processes.

## Diagrams Overview

### 1. Entity Relationship Diagram (ERD) - `erd.mmd`
The ERD shows the database structure and relationships between entities:
- **Geographic Hierarchy**: Provinsi → Kabupaten → Dinas → UPT → BPP → Desa → KelompokTani → AnggotaTani
- **Land Management**: AnggotaTani owns Lahans, which are used for Tanam (planting)
- **Farming Operations**: Tanam relates to Komoditas, Bebantanam (costs), and Panen (harvest)
- **Cost Management**: Beban categorized by Kategori (Variable/Fixed costs)
- **Financial System**: Cash transactions, Journals, and Chart of Accounts

**Key Relationships:**
- One-to-Many: Provinsi has many Kabupatens, etc.
- Many-to-One: Multiple Bebantanam belong to one Tanam
- One-to-Many: One Tanam has many Panens

### 2. Class Diagram - `class-diagram.mmd`
The Class Diagram represents the object-oriented structure of the Laravel models:
- Shows all model classes with their attributes and methods
- Displays relationships between classes
- Includes business logic methods like `getTotalPendapatanAttribute()`, `getKeuntunganAktualAttribute()`
- Shows code generation methods like `getKodeanggota()`, `getKodetanam()`

**Key Classes:**
- Geographic hierarchy classes (Provinsi, Kabupaten, etc.)
- Core farming classes (Tanam, Panen, Bebantanam)
- Financial classes (User, CashTransaction, Journal)

### 3. Business Process Model and Notation (BPMN) - `bpmn.mmd`
The BPMN diagram illustrates the complete business process flow:
1. **Setup Phase**: Geographic data setup and farmer registration
2. **Farming Phase**: Land registration, planting, cost recording
3. **Maintenance Phase**: Ongoing cost tracking
4. **Harvest Phase**: Recording harvest and calculating revenue
5. **Financial Phase**: Recording transactions and generating reports

**Process Flow:**
- Start: Farmer Registration
- Setup: Geographic hierarchy → Komoditas → Beban categories
- Operations: Create Tanam → Record Beban → Maintenance → Harvest
- Financial: Record transactions → Update accounts → Generate reports

### 4. Use Case Diagram - `usecase-diagram.mmd`
The Use Case Diagram shows all actors and their interactions with the system:

**Actors:**
- **BPP Officer**: Primary system operator who inputs, validates, and generates reports
- **Farmer**: Primary beneficiary who views reports and makes decisions
- **Farmer Group Leader**: Optional actor who views aggregated group-level summaries

**Use Case Categories:**
1. **Setup & Configuration**: Geographic data, farmer registration, commodities, cost categories
2. **Cost Transaction Management**: Creating planting cycles, recording costs with BBB/BTKL/BOP classification and Variable/Fixed behavior
3. **Harvest Management**: Recording harvest events (multiple per cycle), calculating revenue, aggregating data
4. **Production Cost Calculations**: Comprehensive metrics including BBB/BTKL/BOP totals, variable/fixed costs, contribution margin, break-even analysis
5. **Report Generation**: Reports per commodity, per cycle, by farmer, by region, and group summaries
6. **Viewing & Analysis**: Farmers evaluate efficiency, analyze cost drivers, view profitability and break-even analysis
7. **Decision Making**: Farmers make decisions based on profitability and break-even thresholds

**Key Relationships:**
- BPP Officers perform all input and validation activities
- Farmers benefit from reports and use them for decision-making
- Group Leaders can view aggregated group-level summaries
- Use cases have dependencies (includes/extends) showing workflow relationships

### 5. Sequence Diagram - `sequence-diagram.mmd`
The Sequence Diagram shows the interaction between components during key operations:
- **Farmer Registration**: User → Controller → Database
- **Planting Process**: Creating Tanam records
- **Cost Recording**: Adding Bebantanam with automatic calculations via database triggers
- **Harvest Process**: Recording Panen and calculating profit
- **Report Generation**: Querying data and calculating totals

**Key Interactions:**
- Controllers interact with Models
- Models query the Database
- Database triggers automatically update related records
- Models perform business calculations

## How to View These Diagrams

### Option 1: Using Mermaid Live Editor
1. Go to https://mermaid.live/
2. Copy the content from any `.mmd` file
3. Paste into the editor
4. The diagram will render automatically

### Option 2: Using VS Code
1. Install the "Markdown Preview Mermaid Support" extension
2. Open the `.mmd` files directly
3. Or create a markdown file with mermaid code blocks

### Option 3: Using GitHub/GitLab
- These platforms automatically render Mermaid diagrams in markdown files
- Create a `.md` file with mermaid code blocks

### Option 4: Using Documentation Tools
- **MkDocs** with `mkdocs-mermaid2-plugin`
- **Docusaurus** with `@docusaurus/theme-mermaid`
- **GitBook** supports Mermaid natively

## Example: Viewing in Markdown

You can also view these diagrams by creating a markdown file:

```markdown
# ERD Diagram
```mermaid
[content from erd.mmd]
```

# Class Diagram
```mermaid
[content from class-diagram.mmd]
```
```

## System Architecture Summary

The UsahaTani system is a comprehensive farming management application built with Laravel that manages:

1. **Geographic Data**: Hierarchical structure from provinces to farmer groups
2. **Farmer Management**: Registration and management of farmers and their lands
3. **Farming Operations**: Tracking planting, costs, and harvests
4. **Cost Accounting**: Detailed cost classification by type (BBB/BTKL/BOP) and behavior (Variable/Fixed)
5. **Production Cost Analysis**: Comprehensive metrics including contribution margin, break-even analysis, and profitability
6. **Financial Management**: Cash flow, journals, and accounting
7. **Reporting**: Production cost reports per commodity, cycle, farmer, region, and group summaries

**Key Features:**
- Cost items classified by production cost type (Material/BBB, Labor/BTKL, Overhead/BOP) and behavior (Variable vs. Fixed)
- Detailed cost transactions per planting cycle (quantity, unit, price, total)
- Multiple harvest events per planting cycle with aggregate output values
- Comprehensive production cost reports with BBB/BTKL/BOP totals, profit/loss, contribution margin, and break-even analysis
- Reports can be summarized by farmer or region
- Optional group-level summaries for farmer group leaders

All diagrams are based on the actual database schema and Laravel models in the codebase.

