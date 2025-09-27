<?php

namespace Database\Seeders\Data;

class QuestionsSeederData
{
    public function data()
    {
        return [
            [
                'id' => 'product',
                'heading' => 'Product',
                'description' => 'How likely is it that this product could be 10× better than what people use today?',
                'choices' => json_encode([
                    ['value' => 0, 'label' => 'No way', 'description' => 'Not likely to be better'],
                    ['value' => 1, 'label' => 'Yes, if it turns out perfectly', 'description' => 'Only if everything works ideally'],
                    ['value' => 2, 'label' => 'At least a 50/50 chance', 'description' => 'Could go either way'],
                    ['value' => 3, 'label' => 'Definitely yes', 'description' => 'Very likely to be 10× better'],
                ]),
            ],
            [
                'id' => 'acquisition',
                'heading' => 'Acquisition',
                'description' => 'Can I find and reach users without spending money?',
                'choices' => json_encode([
                    ['value' => 0, 'label' => 'No idea how to reach them', 'description' => 'Unclear acquisition strategy'],
                    ['value' => 1, 'label' => 'Paid ads could work', 'description' => 'Requires marketing budget'],
                    ['value' => 2, 'label' => 'Some word-of-mouth or viral growth is likely', 'description' => 'Moderate organic potential'],
                    ['value' => 3, 'label' => 'Users will spread it naturally', 'description' => 'Strong organic growth potential'],
                ]),
            ],
            [
                'id' => 'market',
                'heading' => 'Market',
                'description' => 'Is this a big and growing market?',
                'choices' => json_encode([
                    ['value' => 0, 'label' => 'Too small and stagnant', 'description' => 'Market is limited or declining'],
                    ['value' => 1, 'label' => 'Don’t know yet', 'description' => 'Market potential is unclear'],
                    ['value' => 2, 'label' => 'Big or growing', 'description' => 'Market shows strong signs of growth'],
                    ['value' => 3, 'label' => 'Big and growing', 'description' => 'Large and expanding market'],
                ]),
            ],
            [
                'id' => 'defensibility',
                'heading' => 'Defensibility',
                'description' => 'Once it gets traction, will it be hard to copy?',
                'choices' => json_encode([
                    ['value' => 0, 'label' => 'Easy to clone', 'description' => 'Little to no defensibility'],
                    ['value' => 1, 'label' => 'We’ll have a short head start', 'description' => 'Some advantage, but not lasting'],
                    ['value' => 2, 'label' => 'Copying is hard but possible', 'description' => 'Moderate defensibility'],
                    ['value' => 3, 'label' => 'Deep moat, hard to replicate', 'description' => 'Strong defensibility'],
                ]),
            ],
            [
                'id' => 'buildability',
                'heading' => 'Buildability',
                'description' => 'Can I realistically get the people, money and skills needed to build it?',
                'choices' => json_encode([
                    ['value' => 0, 'label' => 'No way', 'description' => 'Not feasible with current resources'],
                    ['value' => 1, 'label' => 'Could find the resources eventually', 'description' => 'Would take significant effort'],
                    ['value' => 2, 'label' => 'We have most of it already', 'description' => 'Mostly feasible with minor gaps'],
                    ['value' => 3, 'label' => 'We’re ready to build today', 'description' => 'Fully feasible right now'],
                ]),
            ],
            ];
    }
}
