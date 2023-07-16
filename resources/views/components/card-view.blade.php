@props([
    'record',
    'cards' => [],
    'modals' => null,
    'widgetData' => [],
    'columns' => [
        'lg' => 2,
    ],
])

<div {{ $attributes->class(['filament-card-stack']) }}>
	<div class="space-y-6">
	    @if ($header = $this->getHeader())
	        {{ $header }}
	    @elseif ($heading = $this->getHeading())
	        <x-filament::header :actions="$this->getCachedActions()">
	            <x-slot name="heading">
	                {{ $heading }}
	            </x-slot>

	            @if ($subheading = $this->getSubheading())
	                <x-slot name="subheading">
	                    {{ $subheading }}
	                </x-slot>
	            @endif
	        </x-filament::header>
	    @endif

	    {{ \Filament\Facades\Filament::renderHook('page.header-widgets.start') }}

	    @if ($headerWidgets = $this->getVisibleHeaderWidgets())
		    <x-filament-support::grid
		        :default="$columns['default'] ?? 1"
		        :sm="$columns['sm'] ?? null"
		        :md="$columns['md'] ?? null"
		        :lg="$columns['lg'] ?? ($columns ? (is_array($columns) ? null : $columns) : 2)"
		        :xl="$columns['xl'] ?? null"
		        :two-xl="$columns['2xl'] ?? null"
		        class="filament-widgets-container gap-4 lg:gap-8 mb-6"
		    >
		    	@forelse( $cards as $key => $card )
			        @foreach ($headerWidgets as $widget)
				    	@php
				    		$widgetData['tableHeading'] = $card;
				    		$widgetData['tableHeadingId'] = $key;
				    		$widgetData['record'] = $record;
				    	@endphp

			            @if ($widget::canView())
			                @livewire(\Livewire\Livewire::getAlias($widget), $widgetData, key($key))
			            @endif
			        @endforeach
			    @empty
				    <x-filament::card>
				    	<h1>No cards found.</h1>
				    	<small>Click on <i class="font-bold">Add card</i> to add new.</small>

				    </x-filament::card>
			    @endforelse
		    </x-filament-support::grid>
	    @endif

	    {{-- slots --}}

	    {{ \Filament\Facades\Filament::renderHook('page.footer-widgets.start') }}

        @if ($footerWidgets = $this->getVisibleFooterWidgets())
            <x-filament::widgets
                :widgets="$footerWidgets"
                :columns="$this->getFooterWidgetsColumns()"
                :data="$widgetData"
            />
        @endif

	    {{ \Filament\Facades\Filament::renderHook('page.footer-widgets.end') }}

	    @if ($footer = $this->getFooter())
	        {{ $footer }}
	    @endif
	</div>

	<form wire:submit.prevent="callMountedAction">
	    @php
	        $action = $this->getMountedAction();
	    @endphp

	    <x-filament::modal
	        id="page-action"
	        :wire:key="$action ? $this->id . '.actions.' . $action->getName() . '.modal' : null"
	        :visible="filled($action)"
	        :width="$action?->getModalWidth()"
	        :slide-over="$action?->isModalSlideOver()"
	        :close-by-clicking-away="$action?->isModalClosedByClickingAway()"
	        display-classes="block"
	        x-init="livewire = $wire.__instance"
	        x-on:modal-closed.stop="if ('mountedAction' in livewire?.serverMemo.data) livewire.set('mountedAction', null)"
	    >
	        @if ($action)
	            @if ($action->isModalCentered())
	                @if ($heading = $action->getModalHeading())
	                    <x-slot name="heading">
	                        {{ $heading }}
	                    </x-slot>
	                @endif

	                @if ($subheading = $action->getModalSubheading())
	                    <x-slot name="subheading">
	                        {{ $subheading }}
	                    </x-slot>
	                @endif
	            @else
	                <x-slot name="header">
	                    @if ($heading = $action->getModalHeading())
	                        <x-filament::modal.heading>
	                            {{ $heading }}
	                        </x-filament::modal.heading>
	                    @endif

	                    @if ($subheading = $action->getModalSubheading())
	                        <x-filament::modal.subheading>
	                            {{ $subheading }}
	                        </x-filament::modal.subheading>
	                    @endif
	                </x-slot>
	            @endif

	            {{ $action->getModalContent() }}

	            @if ($action->hasFormSchema())
	                {{ $this->getMountedActionForm() }}
	            @endif

	            {{ $action->getModalFooter() }}

	            @if (count($action->getModalActions()))
	                <x-slot name="footer">
	                    <x-filament::modal.actions :full-width="$action->isModalCentered()">
	                        @foreach ($action->getModalActions() as $modalAction)
	                            {{ $modalAction }}
	                        @endforeach
	                    </x-filament::modal.actions>
	                </x-slot>
	            @endif
	        @endif
	    </x-filament::modal>
	</form>

	{{ $this->modal }}

	@stack('modals')
</div>
